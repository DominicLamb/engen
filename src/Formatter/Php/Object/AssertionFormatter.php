<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Formatter\Php\Object;

use DominicLamb\EntityGenerator\Assertion\AssertionInterface;
use DominicLamb\EntityGenerator\Assertion;

class AssertionFormatter
{
    public static function format(AssertionInterface $assertion) : string
    {
        $value = $assertion->getValue();

        if ($assertion instanceof Assertion\Higher) {
            return '$value > ' . $value;
        }
        if ($assertion instanceof Assertion\Lower) {
            return '$value < ' . $value;
        }
        if ($assertion instanceof Assertion\Shorter) {
            return 'strlen($value) < ' . $value;
        }
        if ($assertion instanceof Assertion\Longer) {
            return 'strlen($value) > ' . $value;
        }
        throw new \InvalidArgumentException('Assertion not understood: ' . get_class($assertion));
    }
}