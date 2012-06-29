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
        })->to->throwException('Esperance\Error');
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
        })->to->throwException('Esperance\Error');
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
        })->to->throwException('Esperance\Error');
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
        })->to->throwException('Esperance\Error');
    }
}
