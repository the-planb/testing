<?php

namespace PlanB\Tests\String;

use PHPUnit\Framework\TestCase;
use PlanB\DS\CollectionInterface;
use PlanB\DS\Sequence\Sequence;
use PlanB\DS\Sequence\SequenceInterface;
use PlanB\String\WordList;

class WordListTest extends TestCase
{
    public function test_it_can_be_instantiate()
    {
        $wordList = WordList::collect();
        $this->assertInstanceOf(WordList::class, $wordList);
        $this->assertInstanceOf(Sequence::class, $wordList);
        $this->assertInstanceOf(CollectionInterface::class, $wordList);
        $this->assertInstanceOf(SequenceInterface::class, $wordList);
    }

    public function test_it_is_able_to_get_words_from_a_string()
    {
        $wordList = WordList::explode('hola,     que          pasa?');

        $this->assertEquals('hola,', $wordList->get(0));
        $this->assertEquals('que', $wordList->get(1));
        $this->assertEquals('pasa?', $wordList->get(2));

        $this->assertCount(3, $wordList);
    }

    public function test_it_is_able_to_get_words_from_a_string_with_a_limit()
    {
        $wordList = WordList::explode('hola-que-pasa?', '-', 2);

        $this->assertEquals('hola', $wordList->get(0));
        $this->assertEquals('que-pasa?', $wordList->get(1));

        $this->assertCount(2, $wordList);
    }

    public function test_it_is_able_to_get_words_from_a_string_with_a_custom_separator()
    {
        $wordList = WordList::explode('hola,|que|pasa?', '|');

        $this->assertEquals('hola,', $wordList->get(0));
        $this->assertEquals('que', $wordList->get(1));
        $this->assertEquals('pasa?', $wordList->get(2));

        $this->assertCount(3, $wordList);
    }

    public function test_it_is_able_to_get_words_from_a_string_using_a_regexpr()
    {
        $wordList = WordList::split('hola,1que5pasa?', '/[0-9]/');

        $this->assertEquals('hola,', $wordList->get(0));
        $this->assertEquals('que', $wordList->get(1));
        $this->assertEquals('pasa?', $wordList->get(2));

        $this->assertCount(3, $wordList);
    }

    public function test_it_is_able_to_implode()
    {
        $wordList = WordList::explode('hola,     que          pasa?');

        $this->assertEquals('hola, que pasa?', $wordList->implode());
    }

    public function test_it_is_able_to_implode_with_a_custom_separator()
    {
        $wordList = WordList::explode('hola,     que          pasa?');

        $this->assertEquals('hola,-que-pasa?', $wordList->implode('-'));

    }

    public function test_it_is_able_to_do_complex_transformations()
    {
        $text = WordList::explode('AA/BB/CC', '/')
            ->tail()
            ->implode('-');

        $this->assertEquals('BB-CC', $text);
    }
}
