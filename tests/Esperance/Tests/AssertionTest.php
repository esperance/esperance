<?php
namespace Esperance\Tests;

use \Esperance\Assertion;

class AssertionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \Esperance\Error
     */
    public function assert_should_throw_error_if_1st_argument_is_false()
    {
        expect(1)->to->be(1);
    }
}

function expect ($obj)
{
    return new Assertion($obj);
}
