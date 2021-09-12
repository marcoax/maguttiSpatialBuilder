<?php

namespace Magutti\MaguttiSpatial\Builders;


use Illuminate\Database\Eloquent\Builder;
use Magutti\MaguttiSpatial\Traits\PointResolver;
use Magutti\MaguttiSpatial\Traits\UnitConverter;

/**
 * Laravel Builders Mysql Spatial Extension
 */
class SpatialBuilder extends Builder
{
    use UnitConverter, PointResolver;

    /**
     * @param array $point // longitude, latitude
     * @param float $distance // default is  meters
     * @return SpatialBuilder
     */
    public function whereDistance(array $point, float $distance, string $unit = '', string $operator = '<'): SpatialBuilder
    {
        echo $this->pointResolver();
        return $this->whereRaw("ST_Distance_Sphere( Point($point[0], $point[1]),Point(".$this->pointResolver().")) 
                                    $operator ? ", $this->converter( $distance, $unit));
    }

    /**
     * @param array $point
     * @param float $distance
     * @param string $operator
     * @return SpatialBuilder
     */
    public function whereDistanceInKm(array $point, float $distance, string $operator = '<'): SpatialBuilder
    {
        return $this->whereDistance($point, $distance, 'km', $operator);
    }

    /**
     * @param array $point
     * @param float $distance
     * @param string $operator
     * @return SpatialBuilder
     */
    public function whereDistanceInMiles(array $point, float $distance, string $operator = '<'): SpatialBuilder
    {
        return $this->whereDistance($point, $distance, 'mi', $operator);
    }

    /**
     * @param array $point
     * @param float $distance
     * @param string $operator
     * @return SpatialBuilder
     */
    public function whereDistanceInFeet(array $point, float $distance, string $operator = '<'): SpatialBuilder
    {
        return $this->whereDistance($point, $distance, 'ft', $operator);
    }

    /**
     * @param array $point
     * @param float $distance
     * @param string $unit
     * @return SpatialBuilder
     */
    public function whereDistanceLessThan(array $point, float $distance, string $unit = ''): SpatialBuilder
    {
        return $this->whereDistance($point, $distance, $unit);
    }

    /**
     * @param array $point
     * @param float $distance
     * @param string $unit
     * @return SpatialBuilder
     */
    public function whereDistanceMoreThan(array $point, float $distance, string $unit = ''): SpatialBuilder
    {
        return $this->whereDistance($point, $distance, $unit, '>');
    }

    /**
     *
     * get the first point nearest to you
     * @return \Illuminate\Database\Eloquent\Model|object|SpatialBuilder|null
     */
    public function closest()
    {
        return $this->first();
    }


    /**
     * @param array $point // longitude latitude
     * @param array|float[] $factor // to covert meter in your unit
     * @return SpatialBuilder
     */
    public function whitDistance(array $point, array $factor = [1.0]): SpatialBuilder
    {
        return $this->selectRaw("ST_Distance_Sphere(
                                              Point($point[0], $point[1]), 
                                              Point(" . $this->pointResolver() . ")
                                           ) * ? as distance", $factor);
    }

    /**
     * @param array $point  // longitude latitude
     * @return SpatialBuilder
     */
    public function whitDistanceInKm(array $point): SpatialBuilder
    {
        return $this->whitDistance($point, [0.001]);
    }

    /**
     * @param array $point  // longitude latitude
     * @return SpatialBuilder
     */
    public function whitDistanceInMiles(array $point): SpatialBuilder
    {
        return $this->whitDistance($point, [.000621371192]);
    }

    /**
     * @param array $point  // longitude latitude
     * @return SpatialBuilder
     */
    public function whitDistanceInFeet(array $point): SpatialBuilder
    {
        return $this->whitDistance($point, [3.28084]);
    }
}
