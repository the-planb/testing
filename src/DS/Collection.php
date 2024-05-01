<?php

declare(strict_types=1);

namespace PlanB\DS;

use PlanB\DS\Attribute\ElementType;
use PlanB\DS\Exception\InvalidElementType;
use PlanB\DS\Map\MapInterface;
use PlanB\DS\Sequence\SequenceInterface;
use PlanB\DS\Traits\CollectionTrait;

/**
 * @template Key of string|int
 * @template Value
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

    protected readonly bool $filterInput;

    protected array $data;

    /**
     * @param Value[] $input
     * @param string[] $types
     * @param bool $filter
     */
    public function __construct(iterable $input = [], array $types = [], bool $filter = true)
    {
        $elementType = ElementType::fromClass(static::class)
            ->merge(...$types);

        $this->types = $elementType->getTypes();
        $this->filterInput = $filter;

        if ($filter && !in_array('null', $this->types)) {
            $input = array_filter(iterable_to_array($input), fn ($value) => !is_null($value));
        }

        $this->data = $this->dealingData($input);
    }

    protected function dealingData(iterable $input): array
    {
        $input = iterable_to_array($input);
        $data = [];

        foreach ($input as $key => $value) {
            is_of_the_type($value, ...$this->types) || throw InvalidElementType::make($value, $this->types);

            $newKey = $this instanceof MapInterface ? $this->normalizeKey($value, $key) : $key;
            $data[$newKey] = $value;
        }

        return $this instanceof SequenceInterface ? array_values($data) : $data;
    }

    /**
     * @param Value[] $input
     */
    public static function collect(iterable $input = []): static
    {
        return new static($input);
    }

}
