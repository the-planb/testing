<?php

declare(strict_types=1);

namespace PlanB\DS\Vector;

use PlanB\DS\Collection;
use PlanB\DS\Vector\Traits\VectorMutableTrait;

/**
 * @template Key of int
 * @template Value
 * @template-extends Collection<Key, Value>
 */
class VectorMutable extends Collection implements VectorMutableInterface
{
    /**
     * @use VectorMutableTrait<Key, Value>
     */
    use VectorMutableTrait;

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
