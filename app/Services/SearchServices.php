<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SearchServices
{
    public function getFlights(array $filters = []): array
    {
        $key = 'flights:' . md5(json_encode($filters));

        return Cache::remember($key, 300, function () use ($filters) {
            $path = storage_path('app/mocks/flights.json');
            if (!file_exists($path)) {
                return [];
            }

            $json = file_get_contents($path);
            $rows = collect(json_decode($json, true) ?: []);

            $origin = isset($filters['origin']) ? Str::upper(trim($filters['origin'])) : null;
            $destination = isset($filters['destination']) ? Str::upper(trim($filters['destination'])) : null;
            $date = $filters['date'] ?? null;
            $sort = $filters['sort'] ?? null;

            if ($origin) {
                $rows = $rows->filter(function ($r) use ($origin) {
                    return Str::upper($r['origin'] ?? '') === $origin
                        || Str::contains(Str::upper($r['origin'] ?? ''), $origin)
                        || Str::contains(Str::upper($r['airline'] ?? ''), $origin);
                });
            }

            if ($destination) {
                $rows = $rows->filter(function ($r) use ($destination) {
                    return Str::upper($r['destination'] ?? '') === $destination
                        || Str::contains(Str::upper($r['destination'] ?? ''), $destination);
                });
            }

            if ($date) {
                $rows = $rows->filter(function ($r) use ($date) {
                    $dep = $r['departure'] ?? null;
                    if (!$dep) return false;
                    return substr($dep, 0, 10) === $date;
                });
            }

            if ($sort === 'price_asc') {
                $rows = $rows->sortBy(fn($r) => isset($r['price_in_inr']) ? (float)$r['price_in_inr'] : PHP_INT_MAX);
            } elseif ($sort === 'price_desc') {
                $rows = $rows->sortByDesc(fn($r) => isset($r['price_in_inr']) ? (float)$r['price_in_inr'] : 0);
            }

            return $rows->values()->all();
        });
    }

    public function getHotels(array $filters = []): array
    {
        $key = 'hotels:' . md5(json_encode($filters));

        return Cache::remember($key, 300, function () use ($filters) {
            $path = storage_path('app/mocks/hotels.json');
            if (!file_exists($path)) {
                return [];
            }

            $json = file_get_contents($path);
            $rows = collect(json_decode($json, true) ?: []);

            $city = isset($filters['city']) ? Str::lower(trim($filters['city'])) : null;
            $checkin = $filters['checkin'] ?? null;
            $checkout = $filters['checkout'] ?? null;
            $sort = $filters['sort'] ?? null;

            if ($city) {
                $rows = $rows->filter(fn($r) =>
                    Str::lower($r['city'] ?? '') === $city
                    || Str::contains(Str::lower($r['name'] ?? ''), $city)
                );
            }

            if ($checkin && $checkout) {
                $rows = $rows->filter(function ($r) use ($checkin, $checkout) {
                    $from = $r['available_from'] ?? null;
                    $to = $r['available_to'] ?? null;
                    if (!$from || !$to) return false;
                    return ($from <= $checkin) && ($to >= $checkout);
                });
            }

            if ($sort === 'price_asc') {
                $rows = $rows->sortBy(fn($r) => isset($r['price_per_night_in_inr']) ? (float)$r['price_per_night_in_inr'] : PHP_INT_MAX);
            } elseif ($sort === 'price_desc') {
                $rows = $rows->sortByDesc(fn($r) => isset($r['price_per_night_in_inr']) ? (float)$r['price_per_night_in_inr'] : 0);
            }

            return $rows->values()->all();
        });
    }

    public function findItem(string $type, $id): ?array
    {
        $path = storage_path('app/mocks/' . ($type === 'hotel' ? 'hotels.json' : 'flights.json'));
        if (!file_exists($path)) return null;
        $rows = collect(json_decode(file_get_contents($path), true) ?: []);
        return $rows->first(fn($r) => isset($r['id']) && (string)$r['id'] === (string)$id) ?: null;
    }
}
