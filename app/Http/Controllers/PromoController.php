<?php

namespace App\Http\Controllers;
use App\Models\Coupon;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Cek jika user bukan member
        if ($user->membership_status !== 'member') {
            return redirect()->route('home')->with('error', 'Anda harus menjadi member untuk melihat promo.');
        }

        // Tampilkan promo untuk member
        $coupons = Coupon::where('is_active', true)
                         ->whereDate('expires_at', '>=', now())
                         ->get();

        return view('promos.index', compact('coupons'));
    }
}
