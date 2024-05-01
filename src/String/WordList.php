<?php

namespace PlanB\String;

use PlanB\DS\Attribute\ElementType;
use PlanB\DS\Vector\Vector;

#[ElementType('string', \Stringable::class)]
final class WordList extends Vector
{
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
