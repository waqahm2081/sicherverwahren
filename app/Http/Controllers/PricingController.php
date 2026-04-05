<?php

namespace App\Http\Controllers;

use App\Models\PricingPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PricingController extends Controller
{
    public function index()
    {
        $packages = PricingPackage::active()
            ->with([
                'options'          => fn ($q) => $q->orderBy('sort_order'),
                'options.features' => fn ($q) => $q->orderBy('sort_order'),
            ])
            ->orderBy('sort_order')
            ->get();

        return view('pricing', compact('packages'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'                => ['required', 'string', 'max:50'],
            'password'             => ['required', 'confirmed', Password::min(8)],
            'selected_package'     => ['required', 'string', 'max:255'],
            'selected_option_type' => ['required', 'string', 'in:digital,onsite'],
        ]);

        User::create([
            'name'                 => $validated['name'],
            'email'                => $validated['email'],
            'phone'                => $validated['phone'],
            'password'             => Hash::make($validated['password']),
            'selected_package'     => $validated['selected_package'],
            'selected_option_type' => $validated['selected_option_type'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ihr Konto wurde erfolgreich erstellt.',
        ]);
    }
}