<?php
namespace Esperance;

class Assertion
{
    /**
     * Subject for assertion.
     *
     * @var mixed
     */
    private $subject;

    private $flags;

    public function __construct($subject, $flag = NULL)
    {
        $this->subject = $subject;
        $this->flags = array();
    }

    public function __get($key)
    {
        $this->flags[$key] = true;
        return $this;
    }

    public function assert($truth, $message, $error)
    {
        $message = $this->hasFlag('not') ? $error : $message;
        $ok = $this->hasFlag('not') ? !$truth : $truth;

        if (!$ok) {
            throw new Error($message);
        }
    }

    public function hasFlag($key)
    {
        return array_key_exists($key, $this->flags) && $this->flags[$key];
    }

    public function an()
    {
        return $this;
    }

    public function be($obj)
    {
        $this->assert(
            $obj === $this->subject,
            "expected {$this->i($this->subject)} to equal {$this->i($obj)}",
            "expected {$this->i($this->subject)} to not equal {$this->i($obj)}"
        );
        return $this;
    }

    public function equal($obj)
    {
        return $this->be($obj);
    }

    public function ok()
    {
        $this->assert(
            !!$this->subject,
            "expected {$this->i($this->subject)} to be truthy",
            "expected {$this->i($this->subject)} to be falsy"
        );
    }

    public function throwException($klass)
    {
        $this->expect($this->subject)->to->be->callable();

        $thrown = false;
        try {
            call_user_func($this->subject);
        } catch (\Exception $e) {
            $this->expect(get_class($e))->to->be($klass);
            $thrown = true;
        }

        $this->assert(
            $thrown,
            'expected function to throw an exception',
            'expected function not to throw an exception'
        );
    }

    public function callable()
    {
        $this->assert(
            \is_callable($this->subject),
            "expected {$this->i($this->subject)} to be callable",
            "expected {$this->i($this->subject)} to not be callable"
        );
    }

    private function expect($subject)
    {
        return new self($subject);
    }

    private function i($obj)
    {
        return var_export($obj, true);
    }

    public function within($start, $finish)
    {
        $range = "{$start}..{$finish}";
        $this->assert(
            $this->subject >= $start && $this->subject <= $finish,
            "expected {$this->i($this->subject)} to be within {$range}",
            "expected {$this->i($this->subject)} to not be within {$range}"
        );
    }
}
