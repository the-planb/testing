<?php

use PlanB\DS\Map\Map;
use PlanB\DS\Sequence\Sequence;
use PlanB\String\WordList;

if (!function_exists('map')) {
    function map(iterable $input): Map
    {
        return Map::collect($input);
    }
}

if (!function_exists('seq')) {
    function seq(iterable $input): Sequence
    {
        return Sequence::collect($input);
    }
}

if (!function_exists('sequence')) {
    function sequence(iterable $input): Sequence
    {
        return Sequence::collect($input);
    }
}

if (!function_exists('wordList')) {
    function wordList(iterable $input): WordList
    {
        return WordList::collect($input);
    }
}
