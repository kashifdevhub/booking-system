<x-app-layout>
    @section('title', 'Confirm Booking')

    <div class="max-w-4xl mx-auto py-10 px-4">
        <x-flash />

        <h2 class="text-2xl font-semibold mb-4">
            Booking Details – {{ $booking->booking_code }}
        </h2>

        {{-- Booking Summary --}}
        <div class="bg-white rounded shadow p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-sm text-gray-500">Booking Code</div>
                    <div class="font-medium">{{ $booking->booking_code }}</div>
                    <div class="text-xs text-gray-400 mt-1">
                        Type: {{ ucfirst($booking->type) }} · Item: {{ $booking->item_id }}
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Total ({{ $booking->currency }})</div>
                    <div class="text-2xl font-bold">
                        {{ number_format($booking->total_amount, 2) }}
                    </div>
                    <div class="text-xs text-gray-400">Status: {{ ucfirst($booking->status) }}</div>
                </div>
            </div>
        </div>

        {{-- Pricing Breakdown --}}
        <div class="bg-white rounded shadow p-6 mb-6">
            <h3 class="font-semibold mb-2">Pricing Breakdown</h3>
            @if ($booking->pricingBreakdowns->isEmpty())
                <p class="text-gray-500 text-sm">No pricing breakdown found.</p>
            @else
                <ul class="divide-y">
                    @foreach ($booking->pricingBreakdowns as $p)
                        <li class="py-2 flex justify-between">
                            <div>
                                Base INR:
                                <span class="font-medium">₹{{ number_format($p->base_amount_in_inr, 2) }}</span>
                            </div>
                            <div>
                                {{ $p->currency }}
                                <span class="font-medium">{{ number_format($p->total_in_currency, 2) }}</span>
                                <span class="text-xs text-gray-400">
                                    (rate {{ $p->fx_rate_at_booking }})
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Passengers / Guests --}}
        <div class="bg-white rounded shadow p-6">
            <h3 class="font-semibold mb-2">Passengers / Guests</h3>
            @if ($booking->passengers->isEmpty())
                <p class="text-gray-500 text-sm">No passengers added.</p>
            @else
                <ul class="divide-y">
                    @foreach ($booking->passengers as $p)
                        <li class="py-2">
                            <div class="font-medium">{{ $p->name }}</div>
                            <div class="text-xs text-gray-400">
                                {{ $p->email ?? '—' }} · {{ $p->phone ?? '—' }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
