<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Matcher;

use DominicLamb\EntityGenerator\Constraint\MinimumLength;
use DominicLamb\EntityGenerator\Constraint\MaximumLength;
use DominicLamb\EntityGenerator\Entity\Property;
use DominicLamb\EntityGenerator\Parser\Instruction;

class BetweenCharacterLength implements MatcherInterface
{
    public function match(string $string) : bool
    {
        return (bool) preg_match('/^This must be between and characters/', $string);
    }

    public function isNewContext() : bool
    {
        return false;
    }

    public function getTarget() : string
    {
        return self::TARGET_PROPERTY;
    }

    public function validate(Instruction $instruction)
    {
        $values = $instruction->getValues();
        return (
            count($values) === 2
            && ctype_digit($values[0])
            && ctype_digit($values[1])
            && $values[0] < $values[1]
        );
    }

    public function action(Instruction $instruction, Property $property)
    {
        $values = $instruction->getValues();
        $minimumLength = new MinimumLength((int) $values[0]);
        $maximumLength = new MaximumLength((int) $values[1]);

        $property->addConstraint($minimumLength);
        $property->addConstraint($maximumLength);

        return $property;
    }
}
