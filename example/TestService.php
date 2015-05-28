<?php

namespace Acvos\Bubbles\Example;

class TestService
{
    private $foo;
    private $bar;
    private $bob;

    public function __construct($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function getBar()
    {
        return $this->bar;
    }

    public function setBob($newValue)
    {
        $this->bob = $newValue;
    }

    public function getBob()
    {
        return $this->bob;
    }
}