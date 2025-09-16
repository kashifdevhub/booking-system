<x-app-layout>
    @section('title','Dashboard')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome, ') . Auth::user()->name }}
        </h2>
    </x-slot>

    <main class="min-h-screen bg-gray-50 py-12">
        <x-flash />
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- Flight Search --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Search Flights</h3>

                <form method="GET" action="{{ route('search.flights') }}" class="space-y-4">
                    {{-- Inputs in one line --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <input type="text" name="origin" placeholder="Origin" required
                            class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        <input type="text" name="destination" placeholder="Destination" required
                            class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        <input type="date" name="date" required
                            class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        <select name="sort" class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-200">
                            <option value="">Sort</option>
                            <option value="price_asc">Price Low → High</option>
                            <option value="price_desc">Price High → Low</option>
                        </select>
                    </div>

                    {{-- Button in next line --}}
                    <div class="text-center">
                        <button type="submit" class="btn-flight">Search Flights</button>
                    </div>
                </form>
            </div>

            {{-- Hotel Search --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Search Hotels</h3>

                <form method="GET" action="{{ route('search.hotels') }}" class="space-y-4">
                    {{-- Inputs in one line --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <input type="text" name="city" placeholder="City" required
                            class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-green-200">
                        <input type="date" name="checkin" required
                            class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-green-200">
                        <input type="date" name="checkout" required
                            class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-green-200">
                        <select name="sort" class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-green-200">
                            <option value="">Sort</option>
                            <option value="price_asc">Price Low → High</option>
                            <option value="price_desc">Price High → Low</option>
                        </select>
                    </div>

                    {{-- Button in next line --}}
                    <div class="text-center">
                        <button type="submit" class="btn-hotel">Search Hotels</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            // Prevent past dates
            document.addEventListener('DOMContentLoaded', () => {
                const today = new Date().toISOString().split('T')[0];
                document.querySelectorAll('input[type="date"]').forEach(i => {
                    if (!i.value) i.min = today;
                });
            });
        </script>
    @endpush
</x-app-layout>
