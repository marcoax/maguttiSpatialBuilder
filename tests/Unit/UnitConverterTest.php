<?php

namespace Magutti\MaguttiSpatial\Tests\Unit;

use Magutti\MaguttiSpatial\Tests\TestCase;
use Magutti\MaguttiSpatial\Traits\UnitConverter;

class UnitConverterTest extends TestCase
{
    private object $sut;

    protected function setUp(): void
    {
        parent::setUp();

        // A throwaway object that only exposes the UnitConverter trait.
        $this->sut = new class {
            use UnitConverter;
        };
    }

    public function test_get_meters_from_km(): void
    {
        $this->assertSame(1000.0, $this->sut->getMetersFromKm(1));
    }

    public function test_get_meters_from_miles(): void
    {
        $this->assertSame(1609.344, $this->sut->getMetersFromMi(1));
    }

    public function test_get_meters_from_feet(): void
    {
        $this->assertEqualsWithDelta(1.0, $this->sut->getMetersFromFt(3.2808), 0.0001);
    }

    public function test_converter_dispatches_to_the_matching_unit_method(): void
    {
        // 'Km' -> getMetersFromKm() -> 5 km == 5000 meters.
        $this->assertSame(5000.0, $this->sut->converter(5, 'Km'));
    }

    public function test_converter_returns_distance_unchanged_for_unknown_unit(): void
    {
        $this->assertSame(42, $this->sut->converter(42, 'UnknownUnit'));
    }
}
