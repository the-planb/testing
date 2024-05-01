<?php

declare(strict_types=1);

namespace PlanB\DS\Map;

use PlanB\DS\Collection;
use PlanB\DS\Map\Traits\MapTrait;

/**
 * @template Key of string|int
 * @template Value
 * @template-extends Collection<Key, Value>
 */
class MapMutable extends Collection implements MapMutableInterface
{
    /**
     * @use MapTrait<Key, Value>
     */
    use MapTrait;

    /**
     * @param Value[] $input
     */
    public function putAll(iterable $input): static
    {
        $data = $this->dealingData($input);
        $this->data = [
            ...$this->data,
            ...$data,
        ];

        return $this;
    }

    /**
     * @param Key $key
     * @param Value $value
     */
    public function put(mixed $key, mixed $value): static
    {
        return $this->putAll([
            $key => $value,
        ]);
    }

    /**
     * @param Key $key
     */
    public function remove(mixed $key): static
    {
        unset($this->data[$key]);

        return $this;
    }

    /**
     * @param Value $value
     */
    public function removeValue(mixed $value): static
    {
        $key = $this->find($value);
        if (null === $key) {
            return $this;
        }

        return $this->remove($key);
    }
}
