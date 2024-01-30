<?php

declare(strict_types=1);

namespace PlanB\DS\Map;

use PlanB\DS\Map\Traits\MapTrait;

class MapMutable implements MapMutableInterface
{
    use MapTrait;

    public function putAll(iterable $input): static
    {
        $data = $this->dealingData($input);
        $this->data = [
            ...$this->data,
            ...$data,
        ];

        return $this;
    }

    public function put(mixed $key, mixed $value): static
    {
        return $this->putAll([
            $key => $value,
        ]);

    }

    public function remove(mixed $key): static
    {
        unset($this->data[$key]);

        return $this;
    }

    public function removeValue(mixed $value): static
    {
        $key = $this->find($value);
        if (null === $key) {
            return $this;
        }

        return $this->remove($key);
    }
}
