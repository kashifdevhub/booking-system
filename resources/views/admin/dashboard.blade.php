@extends('admin.layouts.main')
@section('title', 'Admin Dashboard')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <h5>Total Bookings</h5>
                        <h2>{{ $totalBookings }}</h2>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <h5>Flight Bookings</h5>
                        <h2>{{ $bookingsByType['flight'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <h5>Hotel Bookings</h5>
                        <h2>{{ $bookingsByType['hotel'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <h5>Total Revenue (INR)</h5>
                        <h2>₹{{ number_format($totalRevenueInInr, 2) }}</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
