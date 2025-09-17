<x-app-layout>
    @section('title', 'Hotel')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <x-flash />
        <h2 class="text-2xl font-semibold mb-4">Search Hotels</h2>

        {{-- Search form --}}
        <form method="GET" action="{{ route('search.hotels') }}" class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-8 gap-3 items-end">
                <div class="md:col-span-3">
                    <label class="text-xs text-gray-600">City</label>
                    <input name="city" value="{{ request('city') }}" placeholder="e.g. Mumbai"
                        class="mt-1 w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-gray-600">Check-in</label>
                    <input name="checkin" type="date" value="{{ request('checkin') }}"
                        class="mt-1 w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-gray-600">Check-out</label>
                    <input name="checkout" type="date" value="{{ request('checkout') }}"
                        class="mt-1 w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-1">
                    <label class="text-xs text-gray-600">Sort</label>
                    <select name="sort" class="mt-1 w-full border rounded px-3 py-2 text-sm">
                        <option value="">Relevance</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: Low → High</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: High → Low</option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Search
                    </button>
                </div>
            </div>
        </form>

        {{-- Results --}}
        @if (empty($hotels) || count($hotels) === 0)
            <div class="bg-white p-6 rounded-lg shadow text-gray-600">No hotels found for the selected filters.</div>
        @else
            <div class="space-y-4">
                @foreach ($hotels as $h)
                    <div
                        class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="text-lg font-semibold">{{ $h['name'] ?? 'Hotel' }}</div>
                            <div class="text-sm text-gray-500">{{ ucfirst($h['city'] ?? '') }} ·
                                {{ $h['room_type'] ?? '' }}</div>
                            <div class="text-xs text-gray-400 mt-1">
                                @if (!empty($h['refundable']))
                                    Refundable
                                @else
                                    Non-refundable
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 md:mt-0 text-right">
                            <div class="text-sm text-gray-500">INR / night</div>
                            <div class="text-2xl font-bold">₹{{ number_format($h['price_per_night_in_inr'] ?? 0) }}
                            </div>

                            <div class="mt-3 flex items-center justify-end gap-2">
                                <a href="{{ route('hotels.details', $h['id']) }}"
                                    class="text-green-600 hover:underline">
                                    View Details
                                </a>


                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="hotel">
                                    <input type="hidden" name="id" value="{{ $h['id'] }}">
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-sm">Add
                                        to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
