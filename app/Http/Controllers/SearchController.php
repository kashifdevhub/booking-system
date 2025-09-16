<?php

namespace App\Http\Controllers;

use App\Services\SearchServices;
use Illuminate\Http\Request;
use App\Services\SearchService;

class SearchController extends Controller
{
    public function __construct(protected SearchServices $searchService) {}

    public function flights(Request $request)
    {
        $filters = $request->only(['origin', 'destination', 'date', 'sort']);
        $flights = $this->searchService->getFlights($filters);
        session(['last_search_results' => array_slice($flights, 0, 6)]);
        return view('search.flights', compact('flights'));
    }

    public function hotels(Request $request)
    {
        $filters = $request->only(['city', 'checkin', 'checkout', 'sort']);
        // note: checkin/checkout can't be used unless hotel data has availability
        $hotels = $this->searchService->getHotels($filters);
        session(['last_search_results' => array_slice($hotels, 0, 6)]);
        return view('search.hotels', compact('hotels'));
    }

    public function flightDetails($id)
    {
        $flight = $this->searchService->findItem('flight', $id);

        if (!$flight) {
            abort(404, 'Flight not found');
        }

        // Pass singular variable, not flights
        return view('details.flight', compact('flight'));
    }

    public function hotelDetails($id)
    {
        $hotel = $this->searchService->findItem('hotel', $id);
        if (!$hotel) {
            abort(404, 'Hotel not found');
        }
        return view('details.hotel', compact('hotel'));
    }


    public function addToCart(Request $request)
    {
        $request->validate([
            'type' => 'required|in:flight,hotel',
            'id' => 'required'
        ]);

        $type = $request->input('type');
        $id = $request->input('id');

        $item = $this->searchService->findItem($type, $id);
        if (!$item) {
            return back()->with('error', 'Item not found.');
        }

        // Build cart item
        if ($type === 'flight') {
            $title = ($item['airline'] ?? 'Flight') . ' — ' . ($item['origin'] ?? '') . ' → ' . ($item['destination'] ?? '');
            $price = isset($item['price_in_inr']) ? (float)$item['price_in_inr'] : 0;
        } else {
            $title = ($item['name'] ?? 'Hotel') . ' — ' . ($item['city'] ?? '');
            $price = isset($item['price_per_night_in_inr']) ? (float)$item['price_per_night_in_inr'] : 0;
        }

        // Get existing cart
        $cart = session('cart.items', []);

        // Prevent duplicate same item (optional). If you want duplicates allowed, remove this check.
        $exists = collect($cart)->first(fn($c) => $c['type'] === $type && (string)$c['id'] === (string)$id);
        if ($exists) {
            return back()->with('info', 'Item already in cart.');
        }

        $cart[] = [
            'type' => $type,
            'id' => $id,
            'title' => $title,
            'price' => $price,
            'meta' => $item,
        ];

        session(['cart.items' => $cart]);
        session()->flash('success', 'Added to cart.');

        return back();
    }

    public function showCart()
    {
        $items = session('cart.items', []);
        $subtotal = collect($items)->sum('price');
        return view('cart.show', compact('items', 'subtotal'));
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'index' => 'required|integer|min:0'
        ]);

        $index = (int)$request->input('index');
        $cart = session('cart.items', []);

        if (!isset($cart[$index])) {
            return back()->with('error', 'Cart item not found.');
        }

        array_splice($cart, $index, 1); // remove item
        session(['cart.items' => $cart]);

        return back()->with('success', 'Item removed.');
    }

    public function clearCart()
    {
        session()->forget('cart.items');
        return back()->with('success', 'Cart cleared.');
    }


}
