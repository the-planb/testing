<?php

declare(strict_types=1);

namespace PlanB\Tests\DS;

use PHPUnit\Framework\TestCase;
use PlanB\DS\CollectionInterface;
use PlanB\DS\Exception\InvalidElementType;
use PlanB\DS\Vector\VectorInterface;
use PlanB\DS\Vector\VectorMutable;
use PlanB\DS\Vector\VectorMutableInterface;
use PlanB\Tests\DS\Traits\ObjectMother;

final class VectorMutableTest extends TestCase
{
    use ObjectMother;


    public function test_it_can_be_instantiate()
    {
        $vector = VectorMutable::collect();
        $this->assertInstanceOf(VectorMutable::class, $vector);
        $this->assertInstanceOf(VectorMutableInterface::class, $vector);
        $this->assertInstanceOf(CollectionInterface::class, $vector);
        $this->assertInstanceOf(VectorInterface::class, $vector);
    }

    public function test_its_possible_to_add_some_new_elements()
    {
        $vector = $this->give_me_a_mutable_and_typed_vector();
        $this->assertTrue($vector->isEmpty());

        $vector->addAll($this->give_me_an_array());
        $this->assertCount(4, $vector);

        $vector->add('value/E');
        $this->assertCount(5, $vector);

        $this->expectException(InvalidElementType::class);
        $this->expectExceptionMessage("The element is of type 'integer' but only 'string' is allowed");
        $vector->add(45);
    }


    public function test_it_is_possible_to_update_a_value()
    {
        $vector = $this->give_me_a_mutable_and_typed_vector();
        $this->assertTrue($vector->isEmpty());

        $vector->add('A');
        $this->assertCount(1, $vector);

        $vector->set(0, 'B');
        $this->assertCount(1, $vector);
        $this->assertEquals('B', $vector->get(0));

        $vector->set(10, 'C');
        $this->assertSame(['B', 'C'], $vector->toArray());
    }

    public function test_it_is_possible_to_remove_an_element_by_index()
    {
        $vector = $this->give_me_a_mutable_and_typed_vector();
        $this->assertTrue($vector->isEmpty());

        $vector->addAll(['A', 'B', 'C']);
        $this->assertCount(3, $vector);

        $vector->remove(1);
        $this->assertSame(['A', 'C'], $vector->toArray());
    }

    public function test_it_is_possible_to_remove_an_element_by_value()
    {
        $vector = $this->give_me_a_mutable_and_typed_vector();
        $this->assertTrue($vector->isEmpty());

        $vector->addAll(['A', 'B', 'C']);
        $this->assertCount(3, $vector);

        $vector->removeValue('B');
        $this->assertSame(['A', 'C'], $vector->toArray());


        $vector->removeValue('X');
        $this->assertSame(['A', 'C'], $vector->toArray());
    }

    public function test_it_is_possible_to_insert_some_elements_in_a_position()
    {
        $vector = $this->give_me_a_mutable_and_typed_vector();
        $vector->addAll(['A', 'B', 'C']);

        $vector->insert(1, 'X', 'Y', 'Z');
        $this->assertSame([
            'A',
            'X',
            'Y',
            'Z',
            'B',
            'C',
        ], $vector->toArray());
    }
}
