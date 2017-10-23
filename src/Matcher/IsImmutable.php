<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Matcher;

use DominicLamb\EntityGenerator\Entity\Property;
use DominicLamb\EntityGenerator\Parser\Instruction;

class IsImmutable implements MatcherInterface
{
    public function match(string $string) : bool
    {
        return (bool) preg_match('/^This cannot be changed/', $string);
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
        return count($values) === 0;
    }

    public function action(Instruction $instruction, Property $property)
    {
        $property->setMutable(false);
        return $property;
    }
}
