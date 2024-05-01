<?php

declare(strict_types=1);

namespace PlanB\DS\Sequence;

use PlanB\DS\Collection;
use PlanB\DS\Sequence\Traits\SequenceTrait;

class Sequence extends Collection implements SequenceImmutableInterface
{
    use SequenceTrait;
}
