<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class User extends Model
{
    /**
     * Get the data-source full-path
     * @var string
     */
    private static $path = 'app\mock.txt';

    /**
     * @var
     */
    private static $data;

    /**
     * Simulate eloquent with file data-source
     * @return Collection
     */
    public static function getAll()
    {
        $file = fopen(storage_path(self::$path), 'r');

        $array_of_records = new Collection();

        while (!feof($file)) {

            $line = fgets($file);

            $record = explode(',', $line);

            if ($line)
                $array_of_records->push(collect([
                    'id' => $record[0],
                    'first_name' => $record[1],
                    'last_name' => $record[2],
                    'gender' => $record[3],
                    'lat' => $record[4],
                    'lon' => $record[5],
                ]));
        }

        fclose($file);

        return $array_of_records->values();
    }

    public static function filterResults()
    {
        return self::getAll()
            ->when(request()->filled('search'), function ($query) {
                $search = request()->input('search');

                return $query->filter(function ($user) use ($search) {
                    return stristr($user['first_name'], $search) || strstr($user['last_name'], $search);
                });
            })
            ->when(request()->filled('gender'), function ($query) {
                $gender = request()->input('gender');

                return $query->filter(function ($user) use ($gender) {
                    return $user['gender'] == $gender;
                });
            })->when(request()->filled('city'), function ($query) {
                $city = explode(',', request()->input('city'));

                $maxDistance = 2000; // in KM

                // Show only people living in a radius of max 2000 KM from a given city
                return $query->filter(function ($user) use ($city, $maxDistance) {
                    return getDistanceBetweenTwoCoords(trim($user['lat']), trim($user['lon']), $city[0], $city[1]) <= $maxDistance;
                });
            })
;
    }

}
