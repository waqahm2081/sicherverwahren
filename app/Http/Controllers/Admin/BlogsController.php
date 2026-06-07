<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    // ── Blog CRUD ────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Blog::with('category')->latest();

        if ($s = $request->get('search')) {
            $query->where('title', 'like', "%{$s}%");
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($cat = $request->get('category')) {
            $query->where('blog_category_id', $cat);
        }

        $blogs      = $query->paginate(15)->withQueryString();
        $categories = BlogCategory::orderBy('name')->get();

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->orderBy('name')->get();
        $blog       = null;
        return view('admin.blogs.form', compact('categories', 'blog'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:blogs,slug',
            'author'           => 'nullable|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'featured_image'   => 'nullable|image|max:4096',
            'tags'             => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'required|in:draft,published',
        ]);

        $data['slug']   = $this->uniqueSlug(empty($data['slug']) ? Str::slug($data['title']) : $data['slug']);
        $data['author'] = $data['author'] ?: 'Sicher Bitcoin Verwahren';
        $data['tags']   = $this->parseTags($request->input('tags'));

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blogbeitrag erfolgreich erstellt.');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::active()->orderBy('name')->get();
        return view('admin.blogs.form', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'author'           => 'nullable|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'featured_image'   => 'nullable|image|max:4096',
            'tags'             => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'required|in:draft,published',
        ]);

        $data['slug']   = $this->uniqueSlug(empty($data['slug']) ? Str::slug($data['title']) : $data['slug'], $blog->id);
        $data['author'] = $data['author'] ?: 'Sicher Bitcoin Verwahren';
        $data['tags']   = $this->parseTags($request->input('tags'));

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        if ($data['status'] === 'published' && ! $blog->published_at) {
            $data['published_at'] = now();
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blogbeitrag erfolgreich aktualisiert.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blogbeitrag erfolgreich gelöscht.');
    }

    // ── Categories ───────────────────────────────────────────────────────────

    public function categoriesIndex()
    {
        $categories = BlogCategory::withCount('blogs')->orderBy('name')->get();
        return view('admin.blogs.categories', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:blog_categories,slug',
            'description' => 'nullable|string|max:500',
        ]);

        $data['slug']      = empty($data['slug']) ? Str::slug($data['name']) : $data['slug'];
        $data['is_active'] = true;

        BlogCategory::create($data);

        return redirect()->route('admin.blogs.categories')
            ->with('success', 'Kategorie erfolgreich erstellt.');
    }

    public function categoryUpdate(Request $request, BlogCategory $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:blog_categories,slug,' . $category->id,
            'description' => 'nullable|string|max:500',
            'is_active'   => 'boolean',
        ]);

        $data['slug']      = empty($data['slug']) ? Str::slug($data['name']) : $data['slug'];
        $data['is_active'] = $request->boolean('is_active', true);

        $category->update($data);

        return redirect()->route('admin.blogs.categories')
            ->with('success', 'Kategorie erfolgreich aktualisiert.');
    }

    public function categoryDestroy(BlogCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.blogs.categories')
            ->with('success', 'Kategorie erfolgreich gelöscht.');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function uniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $base    = $slug;
        $counter = 1;
        while (Blog::where('slug', $slug)->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $base . '-' . $counter++;
        }
        return $slug;
    }

    private function parseTags(?string $raw): array
    {
        if (empty($raw)) return [];
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }
}
