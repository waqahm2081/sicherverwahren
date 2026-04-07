<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPackage;
use App\Models\PricingPackageOption;
use App\Models\PricingOptionFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackagesController extends Controller
{
    public function index()
    {
        $packages = PricingPackage::with(['options.features'])->orderBy('sort_order')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|in:private,business',
            'portfolio_label' => 'required|string|max:255',
            'sort_order'      => 'required|integer|min:0',
        ]);

        $package = PricingPackage::create([
            'name'            => $request->name,
            'slug'            => Str::slug($request->name),
            'category'        => $request->category,
            'portfolio_label' => $request->portfolio_label,
            'sort_order'      => $request->sort_order,
            'is_active'       => $request->boolean('is_active', true),
        ]);

        // Save options
        foreach ($request->input('options', []) as $optData) {
            if (empty($optData['type']) || empty($optData['price_chf'])) continue;

            $option = $package->options()->create([
                'type'           => $optData['type'],
                'label'          => $optData['type'] === 'digital' ? 'Digital Package' : 'On-Site Service',
                'price_chf'      => $optData['price_chf'],
                'is_recommended' => isset($optData['is_recommended']) ? 1 : 0,
                'is_only_option' => isset($optData['is_only_option']) ? 1 : 0,
                'sort_order'     => $optData['sort_order'] ?? 1,
            ]);

            foreach ($optData['features'] ?? [] as $feat) {
                if (empty(trim($feat['feature'] ?? ''))) continue;
                $option->features()->create([
                    'feature'      => $feat['feature'],
                    'is_inherited' => isset($feat['is_inherited']) ? 1 : 0,
                    'sort_order'   => $feat['sort_order'] ?? 1,
                ]);
            }
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket erfolgreich erstellt.');
    }

    public function edit(PricingPackage $package)
    {
        $package->load('options.features');
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, PricingPackage $package)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|in:private,business',
            'portfolio_label' => 'required|string|max:255',
            'sort_order'      => 'required|integer|min:0',
        ]);

        $package->update([
            'name'            => $request->name,
            'slug'            => Str::slug($request->name),
            'category'        => $request->category,
            'portfolio_label' => $request->portfolio_label,
            'sort_order'      => $request->sort_order,
            'is_active'       => $request->boolean('is_active'),
        ]);

        // Replace options and features
        foreach ($package->options as $opt) {
            $opt->features()->delete();
        }
        $package->options()->delete();

        foreach ($request->input('options', []) as $optData) {
            if (empty($optData['type']) || empty($optData['price_chf'])) continue;

            $option = $package->options()->create([
                'type'           => $optData['type'],
                'label'          => $optData['type'] === 'digital' ? 'Digital Package' : 'On-Site Service',
                'price_chf'      => $optData['price_chf'],
                'is_recommended' => isset($optData['is_recommended']) ? 1 : 0,
                'is_only_option' => isset($optData['is_only_option']) ? 1 : 0,
                'sort_order'     => $optData['sort_order'] ?? 1,
            ]);

            foreach ($optData['features'] ?? [] as $feat) {
                if (empty(trim($feat['feature'] ?? ''))) continue;
                $option->features()->create([
                    'feature'      => $feat['feature'],
                    'is_inherited' => isset($feat['is_inherited']) ? 1 : 0,
                    'sort_order'   => $feat['sort_order'] ?? 1,
                ]);
            }
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket erfolgreich aktualisiert.');
    }

    public function toggleActive(PricingPackage $package)
    {
        $package->update(['is_active' => ! $package->is_active]);
        return back()->with('success', 'Status aktualisiert.');
    }

    public function destroy(PricingPackage $package)
    {
        $package->delete();
        return back()->with('success', 'Paket erfolgreich gelöscht.');
    }
}