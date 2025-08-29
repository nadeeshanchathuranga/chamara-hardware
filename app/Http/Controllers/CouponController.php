<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class CouponController extends Controller
{
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }

        $allcoupons = Coupon::orderBy('created_at', 'desc')->get(); //

        return Inertia::render('Coupon/Index', [
            'allCoupons' => $allcoupons,
            'totalCoupons' => $allcoupons->count(),
        ]);
    }

    public function store(Request $request)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'code' => 'required|string|max:191|unique:coupons,code',
            'discount' => 'required|numeric',
        ]);

        Coupon::create($validated);

        return redirect()->route('coupons.index')->banner('Coupon created successfully.');

    }

    public function update(Request $request, Coupon $coupon)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'code' => 'required|string|max:191|unique:coupons,code,' . $coupon->id,
            'discount' => 'required|numeric|max:255',
        ]);

        $coupon->update($validated);

        return redirect()->route('coupons.index')->banner('Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }
        $coupon->delete();
        return redirect()->route('coupons.index')->banner('Coupon Deleted successfully.');
    }
}
