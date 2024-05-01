<?php

declare(strict_types=1);

namespace PlanB\DS\Vector;

use PlanB\DS\Collection;
use PlanB\DS\Vector\Traits\VectorTrait;

/**
 * @template Key of int
 * @template Value
 * @template-extends Collection<Key, Value>
 */
class Vector extends Collection implements VectorImmutableInterface
{
    /**
     * @use VectorTrait<Key, Value>
     */
    use VectorTrait;

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
