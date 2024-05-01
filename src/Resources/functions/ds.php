<?php

use PlanB\DS\Map\Map;
use PlanB\DS\Map\MapMutable;
use PlanB\DS\Vector\Vector;
use PlanB\DS\Vector\VectorMutable;
use PlanB\String\WordList;

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

if (!function_exists('wordList')) {
    function wordList(iterable $input): WordList
    {
        return WordList::collect($input);
    }
}
