@if (session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif

@if (session('info'))
    <div class="mb-4 p-3 bg-blue-50 text-blue-800 rounded">
        {{ session('info') }}
    </div>
@endif
