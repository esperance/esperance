<?php
namespace Esperance\Tests;

use \Esperance\PHPUnit\TestCase;
use \Esperance\Assertion;

class AssertionTest extends TestCase
{
    /**
     * @test
     */
    public function be_should_be_ok_if_subject_is_equal_to_object()
    {
        $this->expect(1)->to->be(1);
    }

    /**
     * @test
     */
    public function be_should_be_error_if_subject_is_not_equal_to_object()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(1)->to->be(2);
        })->to->throw('Esperance\Error', 'expected 1 to equal 2');
    }

    /**
     * @test
     */
    public function eql_should_be_ok_if_subject_is_loosely_equal_to_object()
    {
        $this->expect("1")->to->eql(1);
    }

    /**
     * @test
     */
    public function eql_should_be_error_if_subject_is_not_equal_to_object()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(1)->to->eql(2);
        })->to->throw('Esperance\Error', 'expected 1 to sort of equal 2');
    }

    /**
     * @test
     */
    public function not_be_should_be_ok_if_subject_is_not_equal_to_object()
    {
        $this->expect(1)->to->not->be(2);
    }

    /**
     * @test
     */
    public function not_be_should_be_error_if_subject_is_equal_to_object()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(1)->to->not->be(1);
        })->to->throw('Esperance\Error', 'expected 1 to not equal 1');
    }

    /**
     * @test
     */
    public function throw_should_be_ok_if_expected_exception_is_thrown()
    {
        $this->expect(function () {
            throw new \RuntimeException;
        })->to->throw('RuntimeException');
    }

    /**
     * @test
     */
    public function throw_should_be_ok_if_expected_exception_with_message_is_thrown()
    {
        $this->expect(function () {
            throw new \RuntimeException('expected exception message');
        })->to->throw('RuntimeException', 'expected exception message');
    }

    /**
     * @test
     */
    public function throw_should_be_error_if_expected_exception_is_not_thrown()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(function () {
                // Do nothing.
            })->to->throw('RuntimeException');
        })->to->throw('Esperance\Error');
    }

    /**
     * @test
     */
    public function throw_should_be_error_if_exception_not_expected_is_thrown()
    {
        $this->expect(function () {
            throw new \LogicException;
        })->to->throw('RuntimeException');
    }

    /**
     * @test
     */
    public function ok_should_be_ok_if_subject_is_truthy()
    {
        $this->expect(1)->to->be->ok();
    }

    /**
     * @test
     */
    public function ok_should_be_error_if_subject_is_falsy()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(0)->to->be->ok();
        })->to->throw('Esperance\Error', 'expected 0 to be truthy');
    }

    /**
     * @test
     */
    public function within_should_be_ok_if_subject_is_within_arguments()
    {
        $this->expect(3)->to->be->within(2, 4);
    }

    /**
     * @test
     */
    public function within_should_be_error_if_subject_is_not_within_arguments()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(5)->to->be->within(2, 4);
        })->to->throw('Esperance\Error', 'expected 5 to be within 2..4');
    }

    /**
     * @test
     */
    public function and_should_do_more_assertion()
    {
        $this->expect(1)->not->to->be(2)->and->to->be(1);
    }

    /**
     * @test
     */
    public function and_should_create_another_Assertion_object()
    {
        $a = $this->expect(1);
        $b = $a->to->be(1)->and;
        $this->expect($b)->to->not->be($a);
    }

    /**
     * @test
     */
    public function a_should_be_ok_if_the_subject_is_expected_type()
    {
        $this->expect(new \SplObjectStorage)->to->be->a('SplObjectStorage');
    }

    /**
     * @test
     */
    public function a_should_be_ok_it_the_subject_is_an_instance_of_object()
    {
        $this->expect(new \SplObjectStorage)->to->be->a(new \SplObjectStorage);
    }

    /**
     * @test
     */
    public function a_should_be_ok_if_the_subject_is_subclass_of_expected_type()
    {
        $this->expect(new \SplObjectStorage)->to->be->a('Traversable');
    }

    /**
     * @test
     */
    public function a_should_be_error_if_the_subject_is_not_expected_type()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(new \SplObjectStorage)->to->be->an('ArrayObject');
        })->to->throw('Esperance\Error');
    }

    /**
     * @test
     */
    public function a_should_be_error_if_the_subject_is_not_an_intance_of_object()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(new \SplObjectStorage)->to->be->an(new \ArrayObject);
        })->to->throw('Esperance\Error');
    }

    /**
     * @test
     */
    public function empty_should_be_ok_if_the_subject_is_empty_array()
    {
        $this->expect(array())->to->be->empty();
    }

    /**
     * @test
     */
    public function empty_should_be_ok_if_the_subject_is_NULL()
    {
        $this->expect(NULL)->to->be->empty();
    }

    /**
     * @test
     */
    public function empty_should_be_ok_if_the_subject_is_empty_string()
    {
        $this->expect('')->to->be->empty();
    }

    /**
     * @test
     */
    public function empty_should_be_error_if_the_subject_array_has_an_element()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect(array(1))->to->be->empty();
        })->to->throw('Esperance\Error');
    }

    /**
     * @test
     */
    public function empty_should_be_error_if_the_subject_string_has_a_character()
    {
        $self = $this;
        $this->expect(function () use ($self) {
            $self->expect('a')->to->be->empty();
        })->to->throw('Esperance\Error');
    }
}
