<x-app-layout>
    @section('title', 'Checkout')
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h2 class="text-2xl font-semibold mb-6">Checkout</h2>

        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Your Items</h3>
            <ul class="divide-y">
                @foreach ($items as $it)
                    <li class="py-3 flex justify-between">
                        <div>
                            <div class="font-medium">{{ $it['title'] }}</div>
                            <div class="text-xs text-gray-500">{{ strtoupper($it['type']) }}</div>
                        </div>
                        <div class="font-bold">₹{{ number_format($it['price']) }}</div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4 text-right">
                <div class="text-sm text-gray-500">Subtotal</div>
                <div class="text-2xl font-bold">₹{{ number_format($subtotal) }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('checkout.process') }}"
            class="bg-white rounded shadow p-6 mt-8 space-y-4">
            @csrf
            <input type="hidden" name="currency" value="INR">

            {{-- Show errors --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
                    <div class="font-semibold mb-1">Please fix the following:</div>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 class="text-lg font-semibold mb-4">Passenger / Contact Details</h3>

            <div>
                <label class="block text-sm font-medium">Full Name</label>
                <input type="text" name="contact[name]" value="{{ old('contact.name') }}" required
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="contact[email]" value="{{ old('contact.email') }}" required
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Phone</label>
                <input type="text" name="contact[phone]" value="{{ old('contact.phone') }}" required
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="text-right">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Confirm Booking
                </button>
            </div>
        </form>


    </div>
</x-app-layout>
