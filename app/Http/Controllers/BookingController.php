<?php

namespace App\Http\Controllers;

use App\Jobs\SendBookingEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Booking;
use App\Models\PricingBreakdown;
use App\Models\PassengerOrGuest;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // 🟢 GET /checkout → show checkout page
    public function checkout()
    {
        $items = session('cart.items', []);
        if (empty($items)) {
            return redirect()->route('cart.show')->with('error', 'Cart is empty.');
        }

        $subtotal = collect($items)->sum('price'); // INR prices
        $fxRate = (float) config('booking.inr_to_usd', 0.012);
        $totalUsd = round($subtotal * $fxRate, 2);

        $fxSnapshot = [
            'rate' => $fxRate,
            'base' => 'INR',
            'target' => 'USD',
            'timestamp' => now()->toDateTimeString(),
        ];

        return view('cart.checkout', compact('items', 'subtotal', 'totalUsd', 'fxSnapshot'));
    }

    // 🟢 POST /checkout → save booking
    public function processCheckout(Request $request)
    {
        $request->validate([
            'currency' => 'required|in:INR,USD',
            'contact.name' => 'required|string|max:255',
            'contact.email' => 'required|email',
            'contact.phone' => 'required|string|max:30',
        ]);

        $items = session('cart.items', []);
        if (empty($items)) {
            return redirect()->route('cart.show')->with('error', 'Cart is empty.');
        }

        $baseTotalInInr = collect($items)->sum('price');
        $currencyCode = $request->input('currency', 'INR');

        // FX rate
        $fxRate = 1.0;
        if ($currencyCode !== 'INR') {
            $cur = Currency::where('code', $currencyCode)->first();
            $fxRate = $cur ? (float)$cur->value : (float) config('booking.inr_to_usd', 0.012);
        }

        $totalInCurrency = round($baseTotalInInr * $fxRate, 2);

        DB::beginTransaction();
        try {
            // Create booking
            $booking = Booking::create([
                'booking_code' => strtoupper('BK' . Str::random(8)),
                'type' => $items[0]['type'] ?? 'flight',
                'item_id' => $items[0]['id'] ?? '',
                'customer_id' => auth()->id(),
                'currency' => $currencyCode,
                'total_amount' => $totalInCurrency,
                'status' => 'confirmed',
            ]);
            SendBookingEmailJob::dispatch($booking);

            // Pricing breakdowns
            foreach ($items as $it) {
                $base = (float) ($it['price'] ?? 0);

                PricingBreakdown::create([
                    'booking_id' => $booking->id,
                    'base_amount_in_inr' => $base,
                    'currency' => $currencyCode,
                    'fx_rate_at_booking' => $fxRate,
                    'total_in_currency' => round($base * $fxRate, 2),
                ]);
            }

            // Save single passenger (contact)
            $contact = $request->input('contact', []);
            PassengerOrGuest::create([
                'booking_id' => $booking->id,
                'name' => $contact['name'],
                'email' => $contact['email'],
                'phone' => $contact['phone'],
            ]);

            DB::commit();

            // Clear cart
            session()->forget('cart.items');

            return redirect()->route('bookings.show', $booking->id)
                ->with('success', 'Booking created and email job queued. Reference: ' . $booking->booking_code);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Booking creation failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Unable to create booking. Try again.');
        }
    }

    // 🟢 GET /bookings/{id} → booking details page
    public function show(Booking $booking)
    {
        if ($booking->customer_id && $booking->customer_id !== auth()->id()) {
            abort(403);
        }
        $booking->load(['pricingBreakdowns', 'passengers']);
        return view('bookings.show', compact('booking'));
    }





    public function myBookings()
    {
        $user = Auth::user();

        // eager-load relations (use the relation names from your Booking model)

        $bookings = Booking::with(['passengers', 'customer'])
            ->where('customer_id', $user->id)
            ->latest()
            ->get();
        // dd($bookings);
        return view('bookings.index', compact('bookings'));
    }
}
