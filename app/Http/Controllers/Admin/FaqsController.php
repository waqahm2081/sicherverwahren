<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.form', ['faq' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Faq::create($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ erstellt.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $faq->update($this->validated($request));

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ aktualisiert.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ gelöscht.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer|exists:faqs,id']);

        foreach ($request->order as $index => $id) {
            Faq::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'question'   => 'required|string|max:500',
            'answer'     => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? (Faq::max('sort_order') + 1);

        return $data;
    }
}
