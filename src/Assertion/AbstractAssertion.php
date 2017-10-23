<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Assertion;

abstract class AbstractAssertion implements AssertionInterface
{
    protected $value;

    public function getValue() {
        return $this->value;
    }
}