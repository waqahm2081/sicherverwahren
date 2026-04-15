<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseVideo;
use App\Models\PricingPackage;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function index()
    {
        $videos = CourseVideo::with('packages')->orderBy('sort_order')->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $packages = PricingPackage::active()->orderBy('sort_order')->get();
        return view('admin.videos.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'required|url|max:500',
            'duration'    => 'nullable|string|max:20',
            'tag'         => 'nullable|string|max:100',
            'sort_order'  => 'required|integer|min:0',
            'is_active'   => 'nullable|boolean',
            'packages'    => 'nullable|array',
            'packages.*'  => 'exists:pricing_packages,id',
        ]);

        $video = CourseVideo::create([
            'title'       => $request->title,
            'description' => $request->description,
            'video_url'   => $request->video_url,
            'duration'    => $request->duration,
            'tag'         => $request->tag,
            'sort_order'  => $request->sort_order,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        $video->packages()->sync($request->input('packages', []));

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video erfolgreich erstellt.');
    }

    public function edit(CourseVideo $video)
    {
        $packages        = PricingPackage::active()->orderBy('sort_order')->get();
        $assignedPackages = $video->packages->pluck('id')->toArray();
        return view('admin.videos.edit', compact('video', 'packages', 'assignedPackages'));
    }

    public function update(Request $request, CourseVideo $video)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'required|url|max:500',
            'duration'    => 'nullable|string|max:20',
            'tag'         => 'nullable|string|max:100',
            'sort_order'  => 'required|integer|min:0',
            'is_active'   => 'nullable|boolean',
            'packages'    => 'nullable|array',
            'packages.*'  => 'exists:pricing_packages,id',
        ]);

        $video->update([
            'title'       => $request->title,
            'description' => $request->description,
            'video_url'   => $request->video_url,
            'duration'    => $request->duration,
            'tag'         => $request->tag,
            'sort_order'  => $request->sort_order,
            'is_active'   => $request->boolean('is_active'),
        ]);

        $video->packages()->sync($request->input('packages', []));

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video erfolgreich aktualisiert.');
    }

    public function destroy(CourseVideo $video)
    {
        $video->packages()->detach();
        $video->delete();
        return back()->with('success', 'Video erfolgreich gelöscht.');
    }

    /**
     * AJAX endpoint: receive new sort order from drag-and-drop
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:course_videos,id',
        ]);

        foreach ($request->order as $position => $id) {
            CourseVideo::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json(['success' => true]);
    }
}