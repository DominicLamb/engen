<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Constraint;

use DominicLamb\EntityGenerator\Assertion\Shorter;

class MaximumLength extends AbstractConstraint
{
    protected $name = 'MaximumLength';
    private $length = 0;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function getAssertions() : array
    {
        return [
            new Shorter($this->length)
        ];
    }
}