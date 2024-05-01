<?php

declare(strict_types=1);

namespace PlanB\DS\Map;

use PlanB\DS\Collection;
use PlanB\DS\Map\Traits\MapMutableTrait;

/**
 * @template Key of string|int
 * @template Value
 * @template-extends Collection<Key, Value>
 */
class MapMutable extends Collection implements MapMutableInterface
{
    /**
     * @use MapMutableTrait<Key, Value>
     */
    use MapMutableTrait;

    final public function __construct(iterable $input = [], array $types = [], bool $filter = true)
    {
        parent::__construct($input, $types, $filter);
    }

    /**
     * @param Value[] $input
     */
    public static function collect(iterable $input = []): static
    {
        return new static($input);
    }

}
