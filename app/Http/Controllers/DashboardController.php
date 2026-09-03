<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\PricingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user    = Auth::user();
        $videos  = collect();

        if ($user->selected_option_type === 'digital') {
            $package = PricingPackage::where('name', $user->selected_package)
                ->with(['videos' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
                ->first();

            $videos = $package ? $package->videos : collect();
        }

        return view('dashboard', compact('videos'));
    }

    public function updateProfile(Request $request)
    {
        $user  = Auth::user();
        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        $validated = $request->validate($rules);

        $user->name  = $validated['name'];
        $user->phone = $validated['phone'] ?? $user->phone;

        if ($request->filled('password')) {
            $user->password = $validated['password'];
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Profil erfolgreich aktualisiert.']);
    }
}