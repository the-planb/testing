<?php

declare(strict_types=1);

namespace PlanB\DS;

use PlanB\DS\Attribute\ElementType;
use PlanB\DS\Exception\InvalidElementType;
use PlanB\DS\Map\MapInterface;
use PlanB\DS\Traits\CollectionTrait;
use PlanB\DS\Vector\VectorInterface;

/**
 * @template Key of string|int
 * @template Value
 * @phpstan-consistent-constructor
 */
abstract class Collection implements CollectionInterface
{
    /**
     * @use CollectionTrait<Key, Value>
     */
    use CollectionTrait;

    /**
     * @var string[]
     */
    protected readonly array $types;

    protected array $data;

    /**
     * @param Value[] $input
     * @param string[] $types
     */
    public function __construct(iterable $input = [], callable $mapping = null, array $types = [])
    {
        $this->types = ElementType::fromClass(static::class)
            ->merge(...$types)
            ->getTypes();

        $input = is_callable($mapping) ?
            array_map($mapping, iterable_to_array($input)) :
            iterable_to_array($input);

        $this->data = $this->sanitize($input);
    }

    public static function collect(iterable $input = [], callable $mapping = null): static
    {
        return new static($input, $mapping);
    }

    public function normalize(callable ...$callback): static
    {
        $input = $this->toArray();
        foreach ($callback as $normalizer) {
            $input = array_map($normalizer, $input);
        }

        return new static($input);
    }

    protected function sanitize(array $input): array
    {
        $data = [];
        $ignoreNullValues = !in_array('null', $this->types);

        foreach ($input as $key => $value) {
            if ($ignoreNullValues && $value === null) {
                continue;
            }

            is_of_the_type($value, ...$this->types) || throw InvalidElementType::make($value, $this->types);

            $newKey = $this instanceof MapInterface ? $this->normalizeKey($value, $key) : $key;
            $data[$newKey] = $value;
        }

        return $this instanceof VectorInterface ? array_values($data) : $data;
    }

}
