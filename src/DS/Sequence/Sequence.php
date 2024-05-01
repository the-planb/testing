<?php

declare(strict_types=1);

namespace PlanB\DS\Sequence;

use PlanB\DS\Collection;
use PlanB\DS\Sequence\Traits\SequenceTrait;

/**
 * @template Key of int
 * @template Value
 * @template-extends Collection<Key, Value>
 */
class Sequence extends Collection implements SequenceImmutableInterface
{
    /**
     * @use SequenceTrait<Key, Value>
     */
    use SequenceTrait;
}
