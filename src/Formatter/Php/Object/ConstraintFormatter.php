<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Formatter\Php\Object;

use DominicLamb\EntityGenerator\Constraint\ConstraintInterface;

class ConstraintFormatter
{
    public static function format(ConstraintInterface $constraint) : string
    {
        $assertions = [];
        foreach($constraint->getAssertions() as $assertion)
        {
            $assertions[] = AssertionFormatter::format($assertion);
        }

        return implode(' && ', $assertions);
    }
}