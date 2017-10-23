<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Constraint;

use DominicLamb\EntityGenerator\Assertion\Lower;

class MaximumValue extends AbstractConstraint
{
    protected $name = 'MaximumValue';
    private $value = 0;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getAssertions() : array
    {
        return [
            new Lower($this->value)
        ];
    }
}