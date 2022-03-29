<?php

declare(strict_types=1);

namespace PlanB\Tests\DS\Traits;

use PlanB\DS\CollectionInterface;
use PlanB\DS\Sequence\SequenceInterface;

trait Assertions
{

    private function assertCollectionHasNotChange(CollectionInterface $collection)
    {
        $input = $this->give_me_an_array();
        if ($collection instanceof SequenceInterface) {
            $input = array_values($input);
        }

        $this->assertSame($input, $collection->toArray());
    }
}