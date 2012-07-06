<?php
/**
 * Esperance
 *
 * BDD style assertion library for PHP
 *
 * @author Yuya Takeyama
 */
namespace Esperance;

use \Evenement\EventEmitter;

class Extension
{
    private $emitter;

    public function __construct()
    {
        $this->emitter = new EventEmitter;
    }

    public function beforeAssertion($callback)
    {
        $this->emitter->on('before_assertion', $callback);
    }

    public function onAssertionSuccess($callback)
    {
        $this->emitter->on('assertion_success', $callback);
    }

    public function onAssertionFailure($callback)
    {
        $this->emitter->on('assertion_failure', $callback);
    }

    public function emitBeforeAssertion($args = array())
    {
        $this->emitter->emit('before_assertion', $args);
    }

    public function emitAssertionSuccess($args = array())
    {
        $this->emitter->emit('assertion_success', $args);
    }

    public function emitAssertionFailure($args = array())
    {
        $this->emitter->emit('assertion_failure', $args);
    }
}
