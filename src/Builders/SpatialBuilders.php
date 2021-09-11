<?php

use Illuminate\Database\Eloquent\Builder;

/**
 * Laravel Builders Mysql Spatial Extension
 */
class SpatialBuilder extends Builder{

    /**
     * @param array $point // longitude, latitude
     * @param float $distance // default is  meters
     * @return SpatialBuilder
     */
    public function whereDistance(array $point, float $distance, string $operator = '<'): SpatialBuilder
    {
        return $this->whereRaw("ST_Distance_Sphere(Point($point[0], $point[1]), Point(lng,lat)) $operator $distance");
    }

    public function whereDistanceLessThan(array $point, float $distance): SpatialBuilder
    {
        return $this->whereDistance($point, $distance);
    }

    public function whereDistanceMoreThan(array $point, float $distance): SpatialBuilder
    {
        return $this->whereDistance($point, $distance, '>');
    }


    /**
     * @param array $point
     * @param array|int[] $unit
     * @return SpatialBuilder
     */
    public function whitDistance(array $point,array $unit=[1]): SpatialBuilder
    {
        return $this->selectRaw("ST_Distance_Sphere(Point($point[0], $point[1]), Point(lng, lat)) * ? as distance",$unit);
    }

    /**
     * @param array $point
     * @return SpatialBuilder
     */
    public function whitDistanceInKm(array $point) : SpatialBuilder
    {
        return $this->whitDistance($point,[0.001]);
    }

    /**
     * @param array $point
     * @return SpatialBuilder
     */
    public function whitDistanceInMiles(array $point): SpatialBuilder
    {
        return $this->whitDistance($point,[.000621371192]);
    }

    public function whitDistanceInFeet(array $point) : SpatialBuilder
    {
        return $this->whitDistance($point,[3.28084]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|object|SpatialBuilder|null
     */
    public function nearest()
    {
        return $this->first();
    }
}
