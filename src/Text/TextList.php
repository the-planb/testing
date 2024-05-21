<?php

namespace PlanB\Text;

use PlanB\DS\Attribute\ElementType;
use PlanB\DS\Collection;
use PlanB\DS\Vector\Traits\VectorMutableTrait;
use PlanB\DS\Vector\VectorMutableInterface;

/**
 * @template-extends Collection<int, \Stringable::class>
 */
#[ElementType('string', \Stringable::class)]
final class TextList extends Collection implements VectorMutableInterface
{
    /**
     * @use VectorMutableTrait<int, \Stringable::class>
     */
    use VectorMutableTrait;

    final public function __construct(iterable|string $input = [])
    {
        parent::__construct($input);
    }

    public static function collect(iterable|string $input = []): self
    {
        return new self($input);
    }

    public static function explode(string $text, string $separator = null, int $limit = null): self
    {
        if (is_null($separator)) {
            return self::split($text, '/\s+/', $limit ?? +-1);
        }

        if (is_null($limit)) {
            return self::collect(explode($separator, $text));
        }

        return self::collect(explode($separator, $text, $limit));
    }

    public static function split(string $text, string $pattern, int $limit = -1, int $flags = 0): self
    {
        return self::collect(preg_split($pattern, $text, $limit, $flags));
    }

    public function implode(string $separator = ' '): string
    {
        return implode($separator, $this->toArray());
    }
}
