<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Constraint;

use DominicLamb\EntityGenerator\Assertion\AssertionInterface;

interface ConstraintInterface
{
    const ASSERT_LOWER = 1;
    const ASSERT_HIGHER = 2;
    const ASSERT_EQUAL = 3;
    const ASSERT_IDENTICAL = 4;
    const ASSERT_SHORTER = 5;
    const ASSERT_LONGER = 6;

    public function getName() : string;
    /** @return AssertionInterface[] */
    public function getAssertions() : array;
}