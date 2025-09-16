
<x-app-layout>
      @section('title','Details')
    <div class="max-w-4xl mx-auto py-10 px-4">
        <x-flash />
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                Hotel Details — {{ $hotel['name'] }}
            </h2>

            <div class="space-y-3 text-gray-700">
                <p><strong>City:</strong> {{ $hotel['city'] }}</p>
                <p><strong>Room Type:</strong> {{ $hotel['room_type'] ?? 'N/A' }}</p>
                <p><strong>Available:</strong>
                    {{ $hotel['available_from'] ?? 'N/A' }} → {{ $hotel['available_to'] ?? 'N/A' }}
                </p>
                <p><strong>Price / Night:</strong>
                    <span class="text-lg font-bold text-green-600">
                        ₹{{ number_format($hotel['price_per_night_in_inr'] ?? 0) }}
                    </span>
                </p>
            </div>

            <div class="mt-6">
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="type" value="hotel">
                    <input type="hidden" name="id" value="{{ $hotel['id'] }}">
                    <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
