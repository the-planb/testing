<?php

declare(strict_types=1);

namespace PlanB\Tests\Testing\PhpUnit\Hook;

use PHPUnit\Framework\TestCase;

final class BypassFinalHookTest extends TestCase
{
    public function test_its_possible_create_a_mock_from_a_final_class()
    {

        $this->createMock(FinalClass::class);
        $this->addToAssertionCount(1); //porque no hay un método assertNotException
    }
}
