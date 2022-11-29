<?php

/**
 * Get the approximate distance between two coordinates in km
 */

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

if (!function_exists('getDistanceBetweenTwoCoords')) {
    function getDistanceBetweenTwoCoords($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));

        return $earth_radius * $c;
    }
}

/**
 * Custom pagination for a certain collection
 */

if (!function_exists('paginate')) {
    function paginate($items, $perPage = 24, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
