<?php

declare(strict_types=1);

namespace PlanB\DS\Sequence;

use PlanB\DS\Collection;
use PlanB\DS\Sequence\Traits\SequenceTrait;

class SequenceMutable extends Collection implements SequenceMutableInterface
{
    use SequenceTrait;

    public function addAll(iterable $input): static
    {
        $data = $this->dealingData($input);
        $this->data = [
            ...$this->data,
            ...$data,
        ];

        return $this;
    }

    public function add(mixed $value): static
    {
        return $this->addAll([
            $value,
        ]);
    }

    public function insert(int $index, mixed ...$values): static
    {
        $data = $this->dealingData($values);
        array_splice($this->data, $index, 0, $data);

        return $this;
    }

    public function set(int $index, mixed $value): static
    {
        array_splice($this->data, $index, 1, $value);

        return $this;
    }

    public function removeValue(mixed $value): static
    {
        $index = $this->find($value);

        if (null === $index) {
            return $this;
        }

        return $this->remove($index);
    }

    public function remove(int $index): static
    {
        array_splice($this->data, $index, 1);

        return $this;
    }
}
