<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->whereNotNull('selected_package')
            ->with([]);

        // Search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('selected_package', 'like', "%$s%");
            });
        }

        // Filter by type
        if ($request->filled('type') && in_array($request->type, ['digital', 'onsite'])) {
            $query->where('selected_option_type', $request->type);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'   => User::where('role', 'user')->whereNotNull('selected_package')->count(),
            'digital' => User::where('role', 'user')->where('selected_option_type', 'digital')->whereNotNull('selected_package')->count(),
            'onsite'  => User::where('role', 'user')->where('selected_option_type', 'onsite')->whereNotNull('selected_package')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'user' || ! $user->selected_package, 404);

        // Load the matching package + option + features
        $package = \App\Models\PricingPackage::where('name', $user->selected_package)
            ->with(['options.features'])
            ->first();

        $option = null;
        if ($package) {
            $option = $package->options
                ->firstWhere('type', $user->selected_option_type);
        }

        return view('admin.orders.show', compact('user', 'package', 'option'));
    }
}