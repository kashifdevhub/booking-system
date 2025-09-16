<x-app-layout>
    @section('title', 'Cart')
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h2 class="text-2xl font-semibold mb-6">Your Cart</h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif
        @if (session('info'))
            <div class="mb-4 p-3 bg-blue-50 text-blue-800 rounded">{{ session('info') }}</div>
        @endif

        @if (empty($items) || count($items) === 0)
            <div class="bg-white p-6 rounded shadow text-gray-600">Your cart is empty.</div>
            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Go back to search</a>
            </div>
        @else
            <div class="bg-white rounded shadow divide-y">
                @foreach ($items as $index => $it)
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-500">{{ strtoupper($it['type']) }}</div>
                            <div class="font-semibold">{{ $it['title'] }}</div>
                            <div class="text-xs text-gray-400 mt-1">
                                {{-- small meta: show airline or room type --}}
                                @if ($it['type'] === 'flight')
                                    {{ $it['meta']['airline'] ?? '' }} · Dep: {{ $it['meta']['departure'] ?? '' }}
                                @else
                                    {{ $it['meta']['room_type'] ?? '' }}
                                @endif
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-gray-500">INR</div>
                            <div class="text-xl font-bold">₹{{ number_format($it['price'] ?? 0) }}</div>

                            <div class="mt-3 flex items-center justify-end gap-2">
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="index" value="{{ $index }}">
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 text-white rounded text-sm">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end items-center gap-4">
                <div class="text-right">
                    <div class="text-sm text-gray-500">Subtotal</div>
                    <div class="text-2xl font-bold">₹{{ number_format($subtotal ?? 0) }}</div>
                </div>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-200 rounded">Clear cart</button>
                </form>

                <a href="{{ route('checkout.process') }}"
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Proceed to Checkout</a>
            </div>
        @endif
    </div>
</x-app-layout>
