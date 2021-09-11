<?php

namespace Magutti\MaguttiSpatial\Traits;

/**
 *  Some unit  converter helpers
 */
trait UnitConverter
{
    /**
     * generic converter
     * @param $distance
     * @param string $unit
     * @return mixed
     */
    function converter($distance, string $unit=''){
        $methodName = 'getMetersFrom'.$unit;
        if(method_exists($this,$methodName)) {
            return $this->{$methodName}($distance);
        }
        return $distance;
    }

    /**
     * @param $distance
     * @return float
     */
    function getMiles($distance): float
    {
        return $distance*0.000621371192;
    }

    /**
     * @param $distance
     * @return float
     */
    function getMetersFromMi($distance): float
    {
        return $distance*1609.344;
    }

    /**
     * @param $distance
     * @return float
     */
    function getMetersFromFt($distance): float
    {
        return $distance/3.2808;
    }

    /**
     * @param $distance
     * @return float
     */
    function getMetersFromKm($distance):float
    {
        return $distance*1000;
    }
}