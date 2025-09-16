<x-app-layout>
    @section('title', 'Details')
    <div class="max-w-4xl mx-auto py-10 px-4">
        <x-flash />
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                Flight Details — {{ $flight['id'] }}
            </h2>

            <div class="space-y-3 text-gray-700">
                <p><strong>Airline:</strong> {{ $flight['airline'] }}</p>
                <p><strong>Origin:</strong> {{ $flight['origin'] }}</p>
                <p><strong>Destination:</strong> {{ $flight['destination'] }}</p>
                <p><strong>Departure:</strong> {{ $flight['departure'] }}</p>
                <p><strong>Arrival:</strong> {{ $flight['arrival'] }}</p>
                <p><strong>Duration:</strong> {{ $flight['duration_mins'] }} mins</p>
                <p><strong>Refundable:</strong> {{ $flight['refundable'] ? 'Yes' : 'No' }}</p>
                <p><strong>Price:</strong>
                    <span class="text-lg font-bold text-blue-600">
                        ₹{{ number_format($flight['price_in_inr']) }}
                    </span>
                </p>
            </div>

            <div class="mt-6">
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="type" value="flight">
                    <input type="hidden" name="id" value="{{ $flight['id'] }}">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
