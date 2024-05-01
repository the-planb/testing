<?php

use PlanB\DS\Map\Map;
use PlanB\DS\Map\MapMutable;
use PlanB\DS\Vector\Vector;
use PlanB\DS\Vector\VectorMutable;
use PlanB\Text\TextList;

if (!function_exists('map')) {
    function map(iterable $input = [], array $types = [], bool $filter = true): Map
    {
        return new Map($input, $types, $filter);
    }
}


if (!function_exists('mutable_map')) {
    function mutable_map(iterable $input = [], array $types = [], bool $filter = true): MapMutable
    {
        return new MapMutable($input, $types, $filter);
    }
}

if (!function_exists('vector')) {
    function vector(iterable $input = [], array $types = [], bool $filter = true): Vector
    {
        return new Vector($input, $types, $filter);
    }
}

if (!function_exists('mutable_vector')) {
    function mutable_vector(iterable $input = [], array $types = [], bool $filter = true): VectorMutable
    {
        return new VectorMutable($input, $types, $filter);
    }
}

if (!function_exists('textList')) {
    function textList(iterable $input = [], callable $callback = null): TextList
    {

        $input = !is_null($callback) ?
            vector($input)->map(function ($value, $key) use ($callback) {
                return $callback($value);
            }) :
            $input;

        return TextList::collect($input);
    }
}

if (!function_exists('text_explode')) {
    function text_explode(string $text, string $separator = null, int $limit = null): TextList
    {
        return TextList::explode($text, $separator, $limit);
    }
}

if (!function_exists('text_split')) {
    function text_split(string $text, string $pattern, int $limit = -1, int $flags = 0): TextList
    {
        return TextList::split($text, $pattern, $limit, $flags);
    }
}
