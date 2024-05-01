<?php

declare(strict_types=1);

namespace PlanB\DS\Vector;

use PlanB\DS\CollectionInterface;
use PlanB\DS\Map\MapInterface;

interface VectorInterface extends CollectionInterface
{
    public function hasIndex(int $index): bool;

    public function map(callable $callback): Vector;

    public function toMap(callable $callback): MapInterface;
}
