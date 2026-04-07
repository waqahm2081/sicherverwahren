<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PricingPackage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::where('role', 'user')->count(),
            'total_packages' => PricingPackage::count(),
            'total_orders'   => User::where('role', 'user')
                                    ->whereNotNull('selected_package')
                                    ->count(),
            'digital_orders' => User::where('role', 'user')
                                    ->where('selected_option_type', 'digital')
                                    ->whereNotNull('selected_package')
                                    ->count(),
            'onsite_orders'  => User::where('role', 'user')
                                    ->where('selected_option_type', 'onsite')
                                    ->whereNotNull('selected_package')
                                    ->count(),
            'recent_users'   => User::where('role', 'user')
                                    ->latest()
                                    ->take(5)
                                    ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}