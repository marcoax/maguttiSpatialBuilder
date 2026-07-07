<?php

namespace Magutti\MaguttiSpatial\Tests\Unit;

use Magutti\MaguttiSpatial\Tests\TestCase;
use Magutti\MaguttiSpatial\Traits\PointResolver;

class PointResolverTest extends TestCase
{
    private object $sut;

    protected function setUp(): void
    {
        parent::setUp();

        // A throwaway object that only exposes the PointResolver trait.
        $this->sut = new class {
            use PointResolver;
        };
    }

    public function test_format_points_joins_fields_with_a_comma(): void
    {
        $this->assertSame(
            'longitude,latitude',
            $this->sut->formatPoints(['longitude', 'latitude'])
        );
    }

    public function test_format_points_handles_a_single_field(): void
    {
        $this->assertSame('lng', $this->sut->formatPoints(['lng']));
    }
}
