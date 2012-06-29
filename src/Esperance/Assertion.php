<?php
namespace Esperance;

class Assertion implements \ArrayAccess
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

        if ($parent) {
            $this->flags[$flag] = true;

            foreach ($parent->getFlags() as $i => $_) {
                $this->flags[$i] = true;
            }
        }

        $_flags = $flag ? $this[$flag] : array_keys(self::$defaultFlags);
        $self   = $this;

        if ($_flags && is_array($_flags) && !is_callable($_flags)) {
            for ($i = 0, $l = count($_flags); $i < $l; $i++) {
                if ($this->hasFlag($_flags[$i])) {
                    continue;
                }
                $name = $_flags[$i];
                $assertion = new Assertion($this->obj, $name, $this);
                $this->setAssertion($name, $assertion);
            }
        }
    }

    public function __get($key)
    {
        return $this->assertions[$key];
    }

    public function offsetSet($key, $value)
    {
        $this->assertions[$key] = $value;
    }

    public function offsetGet($key)
    {
        if (method_exists($this, $key)) {
            return array($this, $key);
        } else if (isset(self::$defaultFlags[$key])) {
            return self::$defaultFlags[$key];
        }
    }

    public function offsetExists($key)
    {
        return isset($this->assertions[$key]);
    }

    public function offsetUnset($key)
    {
        unset($this->assertions[$key]);
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

    public function setAssertion($i, $assertion)
    {
        $this->assertions[$i] = $assertion;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function hasFlag($key)
    {
        return array_key_exists($key, $this->flags);
    }

    public function an()
    {
        return $this;
    }

    public function be($obj)
    {
        $this->assert(
            $obj === $this->obj,
            'expected ' . var_export($this->obj, true) . ' to equal ' . var_export($obj, true),
            'expected ' . var_export($this->obj, true) . ' to not equal ' . var_export($obj, true)
        );
        return $this;
    }
}
