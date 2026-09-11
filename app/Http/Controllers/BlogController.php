<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Lead;
use App\Mail\LeadChecklistMail;
use App\Mail\LeadAdminNotification;
use App\Rules\DeliverableEmail;
use App\Services\TurnstileService;
use App\Support\LeadGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

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

    public function submitLead(Request $request, TurnstileService $turnstile)
    {
        // Honeypot: bots that fill hidden fields are silently ignored (no DB row, no mail)
        if ($request->filled('website') || $request->filled('company_url')) {
            return response()->json(['success' => true]);
        }

        // Form opened timestamp — reject instant bot posts (< 2s)
        $openedAt = (int) $request->input('_form_opened_at', 0);
        if ($openedAt > 0 && (time() - $openedAt) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Bitte warten Sie einen Moment und versuchen Sie es erneut.',
            ], 422);
        }

        $ipKey    = 'lead-submit:ip:' . $request->ip();
        $emailKey = 'lead-submit:email:' . strtolower((string) $request->input('email'));

        if (RateLimiter::tooManyAttempts($ipKey, 3) || RateLimiter::tooManyAttempts($emailKey, 2)) {
            return response()->json([
                'success' => false,
                'message' => 'Zu viele Anfragen. Bitte versuchen Sie es später erneut.',
            ], 429);
        }

        $turnstileResult = $turnstile->verify($request);
        if ($turnstileResult === false) {
            return response()->json([
                'success' => false,
                'message' => 'Sicherheitsprüfung fehlgeschlagen. Bitte laden Sie die Seite neu und versuchen Sie es erneut.',
            ], 422);
        }

        try {
            $data = $request->validate([
                'name'   => ['required', 'string', 'min:2', 'max:120'],
                'email'  => ['required', 'string', 'max:255', new DeliverableEmail],
                'source' => ['nullable', 'in:checklist,training'],
            ], [
                'name.required' => 'Bitte geben Sie Ihren Namen ein.',
                'name.min'      => 'Bitte geben Sie einen gültigen Namen ein.',
                'email.required'=> 'Bitte geben Sie Ihre E-Mail-Adresse ein.',
            ]);
        } catch (ValidationException $e) {
            $msg = collect($e->errors())->flatten()->first()
                ?: 'Bitte prüfen Sie Ihre Angaben.';

            return response()->json([
                'success' => false,
                'message' => $msg,
                'errors'  => $e->errors(),
            ], 422);
        }

        if (LeadGuard::looksLikeSpamName($data['name'])) {
            return response()->json([
                'success' => false,
                'message' => 'Bitte geben Sie einen gültigen Namen ein.',
            ], 422);
        }

        RateLimiter::hit($ipKey, 3600);
        RateLimiter::hit($emailKey, 86400);

        $data['email']  = strtolower(trim($data['email']));
        $data['name']   = trim($data['name']);
        $data['source'] = $data['source'] ?? 'checklist';
        $data['status'] = Lead::STATUS_NEW;

        // Same email within 24h → no duplicate lead / no extra emails
        $existing = Lead::where('email', $data['email'])
            ->where('created_at', '>=', now()->subHours(24))
            ->first();

        if ($existing) {
            return response()->json(['success' => true]);
        }

        $lead = Lead::create($data);

        try {
            Mail::to(config('mail.from.address'))->send(new LeadAdminNotification($lead));
            Mail::to($lead->email)->send(new LeadChecklistMail($lead->name));
        } catch (\Throwable $e) {
            report($e);
            // Lead is stored; mail failure should not look like a validation success hang
        }

        return response()->json(['success' => true]);
    }
}
