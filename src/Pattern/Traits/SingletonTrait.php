<?php

declare(strict_types=1);

namespace PlanB\Pattern\Traits;

trait SingletonTrait
{
    private static self $instance;

    private function __construct(mixed ...$args)
    {

    }

    public static function getInstance(): static
    {
        if (!isset(self::$instance)) {
            self::$instance = new self(...func_get_args());
        }

        return self::$instance;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function __clone(): void
    {
    }

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a singleton.');
    }

}
