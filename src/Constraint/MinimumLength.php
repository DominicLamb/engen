<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Constraint;

use DominicLamb\EntityGenerator\Assertion\Longer;

class MinimumLength extends AbstractConstraint
{
    protected $name = 'MinimumLength';
    private $length = 0;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function getAssertions() : array
    {
        return [
            new Longer($this->length)
        ];
    }
}