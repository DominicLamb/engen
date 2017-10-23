<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Constraint;

use DominicLamb\EntityGenerator\Assertion\Higher;

class MinimumValue extends AbstractConstraint
{
    protected $name = 'MinimumValue';
    private $value = 0;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getAssertions() : array
    {
        return [
            new Higher($this->value)
        ];
    }
}