<?php
/**
 * Esperance
 *
 * BDD style assertion library for PHP
 *
 * @author Yuya Takeyama
 */
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

    private $aliases = array(
        'equal'       => 'be',
        'throw'       => 'throwException',
        'throwError'  => 'throwException',
        'callable'    => 'invokable',
        'an'          => 'a',
        'empty'       => '_empty',
        'greaterThan' => 'above',
        'lessThan'    => 'below',
    );

    public function __construct($subject, $flag = NULL)
    {
        $this->subject = $subject;
        $this->flags = array();
    }

    public function __get($key)
    {
        if ($key === 'and') {
            return $this->expect($this->subject);
        } else {
            $this->flags[$key] = true;
            return $this;
        }
    }

    public function __call($method, $args)
    {
        if (array_key_exists($method, $this->aliases)) {
            return call_user_func_array(array($this, $this->aliases[$method]), $args);
        } else {
            throw new \BadMethodCallException("Undefined method {$this->i($method)} is called");
        }
    }

    public function assert($truth, $message, $error)
    {
        $message = isset($this->flags['not']) && $this->flags['not'] ? $error : $message;
        $ok = isset($this->flags['not']) && $this->flags['not'] ? !$truth : $truth;

        if (!$ok) {
            throw new Error($message);
        }
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

    public function eql($obj)
    {
        return $this->assert(
            $this->subject == $obj,
            "expected {$this->i($this->subject)} to sort of equal {$this->i($obj)}",
            "expected {$this->i($this->subject)} to sort of not equal {$this->i($obj)}"
        );
    }

    public function ok()
    {
        $this->assert(
            !!$this->subject,
            "expected {$this->i($this->subject)} to be truthy",
            "expected {$this->i($this->subject)} to be falsy"
        );
    }

    public function throwException($klass, $expectedMessage = NULL)
    {
        $this->expect($this->subject)->to->be->callable();

        $thrown = false;
        try {
            call_user_func($this->subject);
        } catch (\Exception $e) {
            $thrown = true;
            $message = $e->getMessage();
        }

        $this->assert(
            $thrown,
            'expected function to throw an exception',
            'expected function not to throw an exception'
        );
        if ($thrown && $expectedMessage && $message !== $expectedMessage) {
            throw new Error("expected exception message {$this->i($message)} to be {$this->i($expectedMessage)}");
        }
    }

    public function invokable()
    {
        $this->assert(
            \is_callable($this->subject),
            "expected {$this->i($this->subject)} to be callable",
            "expected {$this->i($this->subject)} to not be callable"
        );
    }

    public function a($type)
    {
        if (\is_string($type)) {
            $article = preg_match('/^[aeiou]/i', $type) ? 'an' : 'a';

            $this->assert(
                \is_a($this->subject, $type),
                "expected {$this->i($this->subject)} to be {$article} {$type}",
                "expected {$this->i($this->subject)} not to be {$article} {$type}"
            );
        } else {
            $type = get_class($type);
            $this->assert(
                \is_a($this->subject, $type),
                "expected {$this->i($this->subject)} to be an instance of {$type}",
                "expected {$this->i($this->subject)} not to be an instance of {$type}"
            );
        }
        return $this;
    }

    public function _empty()
    {
        $this->assert(
            empty($this->subject),
            "expected {$this->i($this->subject)} to be empty",
            "expected {$this->i($this->subject)} to not be empty"
        );
        return $this;
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

    public function above($n)
    {
        $this->assert(
            $this->subject > $n,
            "expected {$this->i($this->subject)} to be above {$this->i($n)}",
            "expected {$this->i($this->subject)} to be below {$this->i($n)}"
        );
        return $this;
    }

    public function below($n)
    {
        $this->assert(
            $this->subject < $n,
            "expected {$this->i($this->subject)} to be below {$this->i($n)}",
            "expected {$this->i($this->subject)} to be above {$this->i($n)}"
        );
        return $this;
    }

    public function match($regexp)
    {
        $this->assert(
            preg_match($regexp, $this->subject),
            "expected {$this->i($this->subject)} to match {$regexp}",
            "expected {$this->i($this->subject)} not to match {$regexp}"
        );
        return $this;
    }

    public function length($n)
    {
        if (is_array($this->subject) || (is_object($this->subject) && $this->subject instanceof \Countable)) {
            $len = count($this->subject);
        } else if (is_string($this->subject)) {
            $len = strlen($this->subject);
        } else {
            throw new \InvalidArgumentException('Expected subject for length() is array, string or Countable.');
        }
        $this->assert(
            $len === $n,
            "expected {$this->i($this->subject)} to have a length of {$this->i($n)} but got {$len}",
            "expected {$this->i($this->subject)} to not have a length of {$len}"
        );
        return $this;
    }

    private function expect($subject)
    {
        return new static($subject);
    }

    private function i($obj)
    {
        return var_export($obj, true);
    }
}
