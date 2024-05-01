<?php

namespace PlanB\Tests\Text;

use PHPUnit\Framework\TestCase;
use PlanB\DS\CollectionInterface;
use PlanB\DS\Vector\VectorInterface;
use PlanB\Text\TextList;

class TextListTest extends TestCase
{
    public function test_it_can_be_instantiate()
    {
        $text = TextList::collect();
        $this->assertInstanceOf(TextList::class, $text);
        $this->assertInstanceOf(CollectionInterface::class, $text);
        $this->assertInstanceOf(VectorInterface::class, $text);
    }

    public function test_it_is_able_to_get_words_from_a_string()
    {
        $text = TextList::explode('hola,     que          pasa?');

        $this->assertEquals('hola,', $text->get(0));
        $this->assertEquals('que', $text->get(1));
        $this->assertEquals('pasa?', $text->get(2));

        $this->assertCount(3, $text);
    }

    public function test_it_is_able_to_get_words_from_a_string_with_a_limit()
    {
        $text = TextList::explode('hola-que-pasa?', '-', 2);

        $this->assertEquals('hola', $text->get(0));
        $this->assertEquals('que-pasa?', $text->get(1));

        $this->assertCount(2, $text);
    }

    public function test_it_is_able_to_get_words_from_a_string_with_a_custom_separator()
    {
        $text = TextList::explode('hola,|que|pasa?', '|');

        $this->assertEquals('hola,', $text->get(0));
        $this->assertEquals('que', $text->get(1));
        $this->assertEquals('pasa?', $text->get(2));

        $this->assertCount(3, $text);
    }

    public function test_it_is_able_to_get_words_from_a_string_using_a_regexpr()
    {
        $text = TextList::split('hola,1que5pasa?', '/[0-9]/');

        $this->assertEquals('hola,', $text->get(0));
        $this->assertEquals('que', $text->get(1));
        $this->assertEquals('pasa?', $text->get(2));

        $this->assertCount(3, $text);
    }

    public function test_it_is_able_to_implode()
    {
        $text = TextList::explode('hola,     que          pasa?');

        $this->assertEquals('hola, que pasa?', $text->implode());
    }

    public function test_it_is_able_to_implode_with_a_custom_separator()
    {
        $text = TextList::explode('hola,     que          pasa?');

        $this->assertEquals('hola,-que-pasa?', $text->implode('-'));

    }

    public function test_it_is_able_to_do_complex_transformations()
    {
        $text = TextList::explode('AA/BB/CC', '/')
            ->tail()
            ->implode('-');

        $this->assertEquals('BB-CC', $text);
    }
}
