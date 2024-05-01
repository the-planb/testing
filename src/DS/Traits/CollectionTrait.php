<?php

declare(strict_types=1);

namespace PlanB\DS\Traits;

use JetBrains\PhpStorm\Pure;
use PlanB\DS\Exception\ElementNotFoundException;
use PlanB\DS\Map\Map;
use PlanB\DS\Sequence\Sequence;
use Traversable;

trait CollectionTrait
{
    //CORE
    public function toArray(): array
    {
        return $this->data;
    }

    private function replicate(iterable $input = []): static
    {
        return new static($input, $this->types, $this->filterInput);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return string[]
     */
    public function getAllowedTypes(): array
    {
        return $this->types;
    }

    public function getIterator(): Traversable
    {
        foreach ($this->data as $key => $value) {
            yield $key => $value;
        }
    }

    //COUNT
    #[Pure]
    public function isNotEmpty(): bool
    {
        return 0 !== $this->count();
    }

    public function count(): int
    {
        return count($this->data);
    }

    //GETTERS
    public function first(): mixed
    {
        $key = array_key_first($this->data);

        return $this->data[$key];
    }

    public function firstThat(callable $condition): mixed
    {
        foreach ($this->getIterator() as $key => $value) {
            if ($condition($value, $key)) {
                return $value;
            }
        }
        return null;
    }

    #[Pure]
    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    public function get(mixed $key, mixed $default = null): mixed
    {
        if (1 === func_num_args()) {
            return $this->data[$key] ?? throw ElementNotFoundException::missingKey($key);
        }

        return $this->data[$key] ?? $default;
    }

    public function last(): mixed
    {
        $key = array_key_last($this->data);

        return $this->data[$key] ?? null;
    }

    public function lastThat(callable $condition): mixed
    {
        $data = array_reverse($this->data);
        foreach ($data as $key => $value) {
            if ($condition($value, $key)) {
                return $value;
            }
        }
        return null;
    }


    public function init(): static
    {
        $numOfElements = $this->count() - 1;

        return $this->take($numOfElements);
    }

    public function take(int $numOfElements): static
    {
        $numOfElements = $numOfElements >= 1 ? $numOfElements : 0;

        $input = array_slice($this->data, 0, $numOfElements, true);

        return $this->replicate($input);
    }

    public function tail(): static
    {
        return $this->drop(1);
    }

    public function drop(int $numOfElements): static
    {
        $numOfElements = $numOfElements >= 1 ? $numOfElements : 0;
        $length = $this->count() - $numOfElements;

        $input = array_slice($this->data, $numOfElements, $length, true);

        return $this->replicate($input);
    }

    public function takeWhile(callable $condition): static
    {
        $index = $this->findIndex($condition);

        return $this->take($index);
    }

    private function findIndex(callable $condition): int
    {
        $index = 0;
        foreach ($this as $key => $value) {
            if (!$condition($value, $key)) {
                break;
            }
            $index++;
        }

        return $index;
    }

    public function dropWhile(callable $condition): static
    {
        $index = $this->findIndex($condition);

        return $this->drop($index);
    }

    //INFO
    public function hasValue(mixed $value): bool
    {
        return in_array($value, $this->data);
    }

    public function find(mixed $value): mixed
    {
        $key = array_search($value, $this->data);

        return $key !== false ? $key : null;
    }

    public function contains(mixed ...$values): bool
    {
        foreach ($values as $value) {
            if (!in_array($value, $this->data)) {
                return false;
            }
        }

        return true;
    }

    public function some(callable $condition): bool
    {
        foreach ($this as $key => $value) {
            if ($condition($value, $key)) {
                return true;
            }
        }

        return false;
    }

    public function every(callable $condition): bool
    {
        foreach ($this as $key => $value) {
            if (!$condition($value, $key)) {
                return false;
            }
        }

        return true;
    }

    //MODIFICATION
    public function each(callable $callback): static
    {
        foreach ($this as $key => $value) {
            $callback($value, $key);
        }

        return $this;
    }

    public function filter(callable $condition = null): static
    {
        if (null === $condition) {
            $input = array_filter($this->data);

            return $this->replicate($input);
        }

        $input = array_filter($this->data, $condition, ARRAY_FILTER_USE_BOTH);

        return $this->replicate($input);
    }

    public function sort(callable $comparison = null): static
    {
        $data = $this->toArray();

        if (null === $comparison) {
            asort($data);

            return $this->replicate($data);
        }

        uasort($data, $comparison);

        return $this->replicate($data);
    }

    public function diff(iterable $input, callable $comparison = null): static
    {
        $input = iterable_to_array($input);
        if (is_null($comparison)) {
            $data = array_diff($this->data, $input);

            return $this->replicate($data);
        }

        $data = array_udiff($this->data, $input, $comparison);

        return $this->replicate($data);
    }

    public function unique(callable $callback = null, bool $strict = false): static
    {
        $callback ??= fn (mixed $item) => $item;

        $temp = [];
        $keys = [];
        foreach ($this as $key => $value) {
            $normalized = $callback($value, $key);

            if (!in_array($normalized, $temp, $strict)) {
                $temp[] = $normalized;
                $keys[] = $key;
            }
        }

        return $this->filter(fn (mixed $item, mixed $key) => in_array($key, $keys));
    }

    public function reversed(): static
    {
        $data = array_reverse($this->toArray(), true);

        return $this->replicate($data);
    }

    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        $carry = $initial;
        foreach ($this as $key => $value) {
            $carry = $callback($carry, $value, $key);
        }

        return $carry;
    }

    public function flatMap(callable $callback, int $depth = PHP_INT_MAX): Sequence
    {
        return Map::collect($this->toArray())
            ->map($callback)
            ->flatten($depth);
    }

    public function flatten(int $depth = PHP_INT_MAX): Sequence
    {
        $temp = array_flatten($this->toArray(), $depth);

        return Sequence::collect($temp);
    }

    public function collapse(int $depth = PHP_INT_MAX, string $glue = DIRECTORY_SEPARATOR): static
    {
        $temp = array_collapse($this->toArray(), $depth, $glue);

        return static::collect($temp);
    }

    public function shuffle(): static
    {
        $temp = $this->toArray();
        uksort($temp, fn () => rand() - rand());

        return $this->replicate($temp);
    }

    public function applyTo(callable $callback): mixed
    {
        return $callback($this);
    }
}
