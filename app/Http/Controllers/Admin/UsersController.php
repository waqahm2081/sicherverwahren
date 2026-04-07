<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PricingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name',  'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%");
            });
        }

        if ($request->filled('package')) {
            $query->where('selected_package', $request->package);
        }

        if ($request->filled('type') && in_array($request->type, ['digital', 'onsite'])) {
            $query->where('selected_option_type', $request->type);
        }

        if ($request->filled('order_status')) {
            if ($request->order_status === 'ordered') {
                $query->whereNotNull('selected_package');
            } else {
                $query->whereNull('selected_package');
            }
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total'    => User::where('role', 'user')->count(),
            'ordered'  => User::where('role', 'user')->whereNotNull('selected_package')->count(),
            'digital'  => User::where('role', 'user')->where('selected_option_type', 'digital')->count(),
            'onsite'   => User::where('role', 'user')->where('selected_option_type', 'onsite')->count(),
        ];

        $packages = PricingPackage::orderBy('sort_order')->pluck('name');

        return view('admin.users.index', compact('users', 'stats', 'packages'));
    }

    public function edit(User $user)
    {
        abort_if($user->role === 'admin', 403);
        $packages = PricingPackage::with('options')->orderBy('sort_order')->get();
        return view('admin.users.edit', compact('user', 'packages'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role === 'admin', 403);

        $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'                => ['nullable', 'string', 'max:50'],
            'selected_package'     => ['nullable', 'string', 'max:255'],
            'selected_option_type' => ['nullable', 'in:digital,onsite'],
            'password'             => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name'                 => $request->name,
            'email'                => $request->email,
            'phone'                => $request->phone,
            'selected_package'     => $request->selected_package ?: null,
            'selected_option_type' => $request->selected_option_type ?: null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Benutzer „' . $user->name . '" wurde erfolgreich aktualisiert.');
    }

    public function destroy(User $user)
    {
        abort_if($user->role === 'admin', 403);
        $name = $user->name;
        $user->delete();
        return back()->with('success', 'Benutzer „' . $name . '" wurde gelöscht.');
    }
}