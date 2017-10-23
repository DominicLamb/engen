<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Constraint;

abstract class AbstractConstraint implements ConstraintInterface
{
    protected $name = '';
    protected $assertions = [];

    public function getName() : string
    {
        return $this->name;
    }

    public function getAssertions() : array
    {
        return $this->assertions;
    }
}