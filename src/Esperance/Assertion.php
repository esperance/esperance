<?php
namespace Esperance;

class Assertion
{
    private static $defaultFlags = array(
        'not'  => array('to', 'be', 'have', 'include', 'only'),
        'to'   => array('be', 'have', 'include', 'only', 'not'),
        'only' => array('have'),
        'have' => array('own'),
        'be'   => array('an'),
    );

    private $obj;

    private $flags;

    private $assertions;

    public function __construct($obj, $flag = NULL, $parent = NULL)
    {
        $this->obj = $obj;
        $this->flags = array();
        $this->assertions = array();

        if (is_null($parent)) {
            $this->flags[$flag] = true;

            foreach ($parerent->getFlags() as $key => $flag) {
                $this->flags[$key] = true;
            }
        }

        $_flags = $flag ? $this->defaultFlags[$flag] : array_keys($this->defaultFlags);
        $self   = $this;

        if ($_flags) {
            foreach ($_flags as $key => $name) {
                if ($this->flags[$key]) {
                    continue;
                }

                $assertion = new Assertion($this->obj, $name, $this);

                $this->setAssertion($name, $assertion);
            }
        }
    }

    public function assert($truth, $message, $error)
    {
        $message = $this->flags['not'] ? $error : $message;
        $ok = $this->flags['not'] ? !$truth : $truth;

        if (!$ok) {
            throw new Error;
        }

        $this->setAssertion('and', new Assertion($this->obj));
    }

    public function setAssertion($key, $assertion)
    {
        $this->assertions[$key] = $assertion;
    }
}
