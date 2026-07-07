<?php

namespace Magutti\MaguttiSpatial\Tests\Feature;

use Magutti\MaguttiSpatial\Tests\Fixtures\Place;
use Magutti\MaguttiSpatial\Tests\TestCase;

class SpatialBuilderTest extends TestCase
{
    public function test_where_distance_builds_a_st_distance_sphere_clause(): void
    {
        $query = Place::query()->whereDistance([9.19, 45.46], 1000);

        $this->assertStringContainsString('ST_Distance_Sphere', $query->toSql());
        // No unit given -> distance is passed through untouched (meters).
        $this->assertSame([1000.0], $query->getBindings());
    }

    public function test_where_distance_in_km_converts_the_binding_to_meters(): void
    {
        $query = Place::query()->whereDistanceInKm([9.19, 45.46], 10);

        // 10 km == 10000 meters.
        $this->assertSame([10000.0], $query->getBindings());
    }

    public function test_where_distance_more_than_uses_the_greater_than_operator(): void
    {
        $query = Place::query()->whereDistanceMoreThan([9.19, 45.46], 500);

        $this->assertStringContainsString('> ?', $query->toSql());
    }

    public function test_whit_distance_selects_a_distance_alias(): void
    {
        $query = Place::query()->whitDistanceInKm([9.19, 45.46]);

        $this->assertStringContainsString('as distance', $query->toSql());
        $this->assertSame([0.001], $query->getBindings());
    }

    /**
     * Characterization test: the coordinates are interpolated straight into the
     * raw SQL string (Point($point[0], $point[1])), NOT sent as bindings.
     * This test pins that current behavior so we notice if it ever changes.
     */
    public function test_coordinates_are_interpolated_literally_into_the_sql(): void
    {
        $query = Place::query()->whereDistance([9.19, 45.46], 1000);

        // The coordinates appear verbatim in the query string...
        $this->assertStringContainsString('Point(9.19, 45.46)', $query->toSql());
        // ...and only the distance is a bound parameter (no coords in bindings).
        $this->assertSame([1000.0], $query->getBindings());
    }

    public function test_string_coordinates_are_not_escaped_and_leak_into_the_sql(): void
    {
        $query = Place::query()->whereDistance(["where=1", 45.46], 1000);
        $this->assertStringContainsString('Point(where=1, 45.46)', $query->toSql());
    }
}
