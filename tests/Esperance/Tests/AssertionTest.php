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
     * @expectedException \Esperance\Error
     */
    public function be_should_be_error_if_subject_is_not_equal_to_object()
    {
        $this->expect(1)->to->be(2);
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
     * @expectedException \Esperance\Error
     */
    public function not_be_should_be_error_if_subject_is_equal_to_object()
    {
        $this->expect(1)->to->not->be(1);
    }
}
