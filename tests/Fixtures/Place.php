<?php

namespace Magutti\MaguttiSpatial\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Magutti\MaguttiSpatial\Builders\SpatialBuilder;

/**
 * Minimal Eloquent model used only in tests. It overrides newEloquentBuilder()
 * so that every query starts from our SpatialBuilder, exactly like a real model
 * that wants the whereDistance()/whitDistance() helpers.
 */
class Place extends Model
{
    protected $table = 'places';

    protected $guarded = [];

    public $timestamps = false;

    public function newEloquentBuilder($query): SpatialBuilder
    {
        return new SpatialBuilder($query);
    }
}
