<?php

declare(strict_types=1);

namespace PlanB\Type;

interface BooleanValue
{
    public function toBoolean(): bool;
}
