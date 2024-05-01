<?php

declare(strict_types=1);

namespace PlanB\DS\Sequence\Traits;

use PlanB\DS\Map\Map;
use PlanB\DS\Sequence\Sequence;

/**
 * @template Key of int
 * @template Value
 */
trait SequenceTrait
{
    /**
     * @template ReturnType
     * @param callable(Value, Key): ReturnType $callback
     * @return Sequence<ReturnType>
     */
    public function map(callable $callback): Sequence
    {
        $input = [];
        foreach ($this as $key => $value) {
            $input[$key] = $callback($value, $key);
        }

        return new Sequence($input);
    }

    public function hasIndex(int $index): bool
    {
        return array_key_exists($index, $this->data);
    }

    /**
     * @param callable(Value, Key): Key $callback
     * @return Map<Value>
     */
    public function toMap(callable $callback): Map
    {
        return (new Map($this->data, $this->types, $this->filterInput))
            ->mapKeys($callback);
    }

}
