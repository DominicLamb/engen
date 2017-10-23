<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Assertion;

class Longer extends AbstractAssertion
{
    public function __construct(int $value)
    {
        $this->value = $value;
    }
}