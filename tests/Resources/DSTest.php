<?php

declare(strict_types=1);

namespace PlanB\Tests\Resources\functions;

use PHPUnit\Framework\TestCase;
use PlanB\DS\Map\Map;
use PlanB\DS\Map\MapMutable;
use PlanB\DS\Vector\Vector;
use PlanB\DS\Vector\VectorMutable;

final class DSTest extends TestCase
{

    public function test_it_map_alias_works()
    {
        $map = map();
        $this->assertInstanceOf(Map::class, $map);
    }

    public function test_it_mutable_map_alias_works()
    {
        $map = mutable_map();
        $this->assertInstanceOf(MapMutable::class, $map);
    }

    public function test_it_vector_alias_works()
    {
        $vector = vector();
        $this->assertInstanceOf(Vector::class, $vector);

    }

    public function test_it_mutable_vector_alias_works()
    {
        $vector = mutable_vector();
        $this->assertInstanceOf(VectorMutable::class, $vector);
    }
}
