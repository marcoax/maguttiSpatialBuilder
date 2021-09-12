<?php

namespace Magutti\MaguttiSpatial\Traits;

trait PointResolver
{
    function pointResolver()
    {

        if (property_exists($this->model, 'spatialFields')) {
            return $this->getPoints();
        };

        return $this->formatPoints(config('magutti-spatial.spatial_fields'));
    }

    function getPoints()
    {

        return $this->formatPoints($this->model->spatialFields);
    }

    function formatPoints(array $points):string
    {
        return implode(',', $points);
    }
}