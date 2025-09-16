@extends('admin.layouts.main')
@section('title', 'Bookings')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Bookings</h1>
        <table id="bookings-table" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Booking Code</th>
                    <th>Hotel / Flight ID</th>
                    <th>Type</th>
                    <th>Passenger</th>
                    <th>Total (INR)</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    @php
                        // prefer passenger saved at checkout
                        $passenger = $booking->passengers->first();
                        $contactName = $passenger->name ?? 'N/A';
                        $contactEmail = $passenger->email ?? 'N/A';
                        $contactPhone = $passenger->phone ?? 'N/A';
                        $totalInr = $booking->pricingBreakdowns->sum('base_amount_in_inr');
                    @endphp

                    <tr>
                        <td>{{ $booking->booking_code }}</td>
                        <td>{{ $booking->item_id }}</td>
                        <td class="text-capitalize">{{ $booking->type }}</td>

                        <td>
                            <div class="font-medium">{{ $contactName }}</div>
                            <div class="text-xs text-muted">{{ $contactEmail }} · {{ $contactPhone }}</div>
                        </td>

                        <td>₹{{ number_format($totalInr, 2) }}</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                        <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No bookings found.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>


    </div>
@endsection
