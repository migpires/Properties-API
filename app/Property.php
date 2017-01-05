<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Property extends Model
{

    protected $fillable = [
        'address', 'latitude', 'longitude', 'user_id',
    ];

    public static function scopeDistance($query, $latitude, $longitude, $radius, $unit)
    {
        $unit = ($unit === "km") ? 6378.10 : 3963.17;
        $latitude = (float) $latitude;
        $longitude = (float) $longitude;
        $radius = (double) $radius;
        return $query->having('distance','<=',$radius)
                    ->select(DB::raw("*,
                                ($unit * ACOS(COS(RADIANS($latitude))
                                    * COS(RADIANS(latitude))
                                    * COS(RADIANS($longitude) - RADIANS(longitude))
                                    + SIN(RADIANS($latitude))
                                    * SIN(RADIANS(latitude)))) AS distance")
                    )->orderBy('distance','asc')->get();
    }

}
