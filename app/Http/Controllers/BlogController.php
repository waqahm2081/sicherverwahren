<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Lead;
use App\Mail\LeadChecklistMail;
use App\Mail\LeadAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with('category')->published()->latest('published_at');

        if ($cat = $request->get('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $cat));
        }

        $blogs          = $query->paginate(9)->withQueryString();
        $categories     = BlogCategory::active()->withCount('publishedBlogs')->orderBy('name')->get();
        $activeCategory = $cat ? BlogCategory::where('slug', $cat)->first() : null;

        return view('blog.index', compact('blogs', 'categories', 'activeCategory'));
    }

    public function show(string $slug)
    {
        $blog = Blog::with('category')->published()->where('slug', $slug)->firstOrFail();

        $related = Blog::with('category')
            ->published()
            ->where('id', '!=', $blog->id)
            ->when($blog->blog_category_id, fn ($q) => $q->where('blog_category_id', $blog->blog_category_id))
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('blog', 'related'));
    }

    public function submitLead(Request $request)
    {
        if ($request->filled('website')) {
            return response()->json(['success' => true]);
        }

        $key = 'lead-submit:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'success' => false,
                'message' => 'Zu viele Anfragen. Bitte versuchen Sie es später erneut.',
            ], 429);
        }
        RateLimiter::hit($key, 3600);

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'source' => 'nullable|in:checklist,training',
        ]);

        $data['source'] = $data['source'] ?? 'checklist';
        $data['status'] = Lead::STATUS_NEW;

        $existing = Lead::where('email', $data['email'])
            ->where('created_at', '>=', now()->subHours(24))
            ->first();

        if ($existing) {
            return response()->json(['success' => true]);
        }

        $lead = Lead::create($data);

        Mail::to(config('mail.from.address'))->send(new LeadAdminNotification($lead));
        Mail::to($lead->email)->send(new LeadChecklistMail($lead->name));

        return response()->json(['success' => true]);
    }
}
