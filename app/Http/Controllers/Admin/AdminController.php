<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBookings = Booking::count();

        $bookingsByType = Booking::select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $totalRevenueInInr = DB::table('pricing_breakdowns')->sum('base_amount_in_inr');

        $latestBookings = Booking::latest()
            ->with(['pricingBreakdowns', 'customer'])
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'bookingsByType',
            'totalRevenueInInr',
            'latestBookings',

        ));
    }


    public function bookings()
    {
        $bookings = Booking::with(['pricingBreakdowns', 'passengers'])
            ->latest()
            ->take(5)   // last 5
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }
}
