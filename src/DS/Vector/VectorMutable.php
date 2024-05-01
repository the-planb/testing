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
class VectorMutable extends Collection implements VectorMutableInterface
{
    /**
     * @use VectorTrait<Key, Value>
     */
    use VectorTrait;

    /**
     * @param Value[] $input
     */
    public function addAll(iterable $input): static
    {
        $data = $this->dealingData($input);
        $this->data = [
            ...$this->data,
            ...$data,
        ];

        return $this;
    }

    /**
     * @param Value $value
     */
    public function add(mixed $value): static
    {
        return $this->addAll([
            $value,
        ]);
    }

    /**
     * @param int $index
     * @param Value ...$values
     */
    public function insert(int $index, mixed ...$values): static
    {
        $data = $this->dealingData($values);
        array_splice($this->data, $index, 0, $data);

        return $this;
    }

    /**
     * @param int $index
     * @param Value $value
     */
    public function set(int $index, mixed $value): static
    {
        array_splice($this->data, $index, 1, $value);

        return $this;
    }

    /**
     * @param Value $value
     */
    public function removeValue(mixed $value): static
    {
        $index = $this->find($value);

        if (null === $index) {
            return $this;
        }

        return $this->remove($index);
    }

    /**
     * @param int $index
     * @return $this
     */
    public function remove(int $index): static
    {
        array_splice($this->data, $index, 1);

        return $this;
    }
}
