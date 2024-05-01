<?php

declare(strict_types=1);

namespace PlanB\Tests\DS\Traits;

use DateTime;
use PlanB\DS\Attribute\ElementType;
use PlanB\DS\Collection;
use PlanB\DS\CollectionInterface;
use PlanB\DS\Map\Map;
use PlanB\DS\Map\MapInterface;
use PlanB\DS\Map\MapMutable;
use PlanB\DS\Vector\Vector;
use PlanB\DS\Vector\VectorInterface;
use PlanB\DS\Vector\VectorMutable;
use Prophecy\PhpUnit\ProphecyTrait;

trait  ObjectMother
{
    use ProphecyTrait;

    private function give_me_a_typed_collection(iterable $input = [], array $types = [], bool $filter = true): CollectionInterface
    {
        return new #[ElementType('string', DateTime::class)] class($input, $types, $filter) extends Collection {

        };
    }

    private function give_me_an_empty_collection(): CollectionInterface
    {
        return $this->give_me_a_collection([]);
    }

    private function give_me_a_collection(?iterable $input = null, array $types = [], bool $filter = true): CollectionInterface
    {
        $input = is_null($input) ? $this->give_me_an_array() : $input;

        return new  class($input, $types, $filter) extends Collection {

            public static function collect(iterable $input = []): static
            {
                return new static($input);
            }
        };
    }

    private function give_me_an_array(): array
    {
        return [
            'A' => 'value/A',
            'B' => 'value/B',
            'C' => 'value/C',
            'D' => 'value/D',
        ];
    }

    private function give_me_a_vector(?iterable $input = null): VectorInterface
    {
        $input = is_null($input) ? $this->give_me_an_array() : $input;

        return Vector::collect($input);
    }

    private function give_me_a_map(?iterable $input = null): MapInterface
    {
        $input = is_null($input) ? $this->give_me_an_array() : $input;

        return Map::collect($input);
    }

    private function give_me_an_empty_map(): MapInterface
    {
        return Map::collect([]);
    }

    private function give_me_a_mutable_and_typed_map(iterable $input = [], array $types = [], bool $filter = true): MapMutable
    {
        return new #[ElementType('string')] class($input, $types, $filter) extends MapMutable {

        };
    }

    private function give_me_a_mutable_and_typed_vector(iterable $input = [], array $types = [], bool $filter = true): VectorMutable
    {
        return new #[ElementType('string')] class($input, $types, $filter) extends VectorMutable {

        };
    }

}