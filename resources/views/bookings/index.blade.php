<x-app-layout>
     @section('title', 'My Bookings')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @forelse($bookings as $booking)
                    <div class="border rounded-md p-4 mb-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-lg">
                                    Booking #{{ $booking->id }}
                                    <span class="text-sm text-gray-600">
                                        ({{ ucfirst($booking->type ?? 'N/A') }})
                                    </span>
                                </h3>

                                <div class="text-sm text-gray-500">
                                    <span>Reference: {{ $booking->booking_code ?? '-' }}</span>
                                    <span class="mx-2">|</span>
                                    <span>Item ID: {{ $booking->item_id ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="text-right text-sm text-gray-500">

                                <a href="{{ route('bookings.show', $booking->id) }}"
                                    class="text-indigo-600 hover:underline">View details</a>
                            </div>
                        </div>

                        {{-- Show total amount from bookings table --}}
                        <div class="mt-3 text-lg font-semibold text-gray-800">
                            Amount: {{ number_format($booking->total_amount ?? 0, 2) }}
                            {{ $booking->currency ?? 'INR' }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">No bookings found.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
