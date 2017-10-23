<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Assertion;

class Higher extends AbstractAssertion
{
    public function __construct(int $value)
    {
        $this->value = $value;
    }
}