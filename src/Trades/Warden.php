<?php
/* This file is part of Nietzsche | SSITU | (c) 2021 I-is-as-I-does */
namespace SSITU\Nietzsche\Trades;

class Warden
{
    private $variables;

    public function __construct($variables = [])
    {
        $this->variables = $variables;
    }

    public function __isset($name)
    {
        if (!array_key_exists($name, $this->variables)) {
            throw new \Exception("missing: $name");
        }

        return true;
    }

    public function __get($name)
    {
        return $this->variables[$name];
    }
}
