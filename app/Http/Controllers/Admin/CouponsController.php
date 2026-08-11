<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('code')->get();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'discount_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'is_active'        => ['nullable', 'boolean'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        $coupon->update([
            'discount_percent' => $validated['discount_percent'],
            'is_active'        => $request->boolean('is_active'),
            'notes'            => $validated['notes'] ?? $coupon->notes,
        ]);

        return back()->with('success', 'Rabattcode „' . $coupon->code . '" aktualisiert.');
    }
}
