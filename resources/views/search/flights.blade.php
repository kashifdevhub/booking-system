<x-app-layout>
     @section('title','Flight')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <x-flash />
        <h2 class="text-2xl font-semibold mb-4">Search Flights</h2>

        <form method="GET" action="{{ route('search.flights') }}" class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-8 gap-3 items-end">
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-600">Origin</label>
                    <input name="origin" value="{{ request('origin') }}" placeholder="DEL or New Delhi"
                        class="mt-1 w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-gray-600">Destination</label>
                    <input name="destination" value="{{ request('destination') }}" placeholder="BOM or Mumbai"
                        class="mt-1 w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-gray-600">Departure</label>
                    <input name="date" type="date" value="{{ request('date') }}"
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
        @if (empty($flights) || count($flights) === 0)
            <div class="bg-white p-6 rounded-lg shadow text-gray-600">No flights found for the selected filters.</div>
        @else
            <div class="space-y-4">
                @foreach ($flights as $f)
                    <div
                        class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-14">
                                <div
                                    class="h-12 w-12 rounded-md bg-slate-100 flex items-center justify-center text-sm font-bold text-slate-700">
                                    {{ strtoupper(substr($f['airline'] ?? 'NA', 0, 2)) }}
                                </div>
                            </div>

                            <div>
                                <div class="text-sm text-gray-500">{{ $f['airline'] ?? 'Airline' }}</div>
                                <div class="font-semibold text-lg">
                                    {{ $f['origin'] ?? '' }} → {{ $f['destination'] ?? '' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    Departure:
                                    {{ isset($f['departure']) ? \Illuminate\Support\Str::substr($f['departure'], 0, 16) : '-' }}
                                    · Duration: {{ $f['duration_mins'] ?? '-' }} mins
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    @if (!empty($f['refundable']))
                                        Refundable
                                    @else
                                        Non-refundable
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-0 text-right">
                            <div class="text-sm text-gray-500">INR</div>
                            <div class="text-2xl font-bold">₹{{ number_format($f['price_in_inr'] ?? 0) }}</div>

                            <div class="mt-3 flex items-center justify-end gap-2">
                                <a href="{{ route('flights.details', $f['id']) }}"
                                    class="text-blue-600 hover:underline">
                                    View Details
                                </a>


                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="flight">
                                    <input type="hidden" name="id" value="{{ $f['id'] }}">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Add
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
