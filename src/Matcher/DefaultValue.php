<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Matcher;

use DominicLamb\EntityGenerator\Entity\Property;
use DominicLamb\EntityGenerator\Parser\Instruction;

class DefaultValue implements MatcherInterface
{
    public function match(string $string) : bool
    {
        return (bool) preg_match('/^This must be when not given/', $string);
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
        return count($values) === 1;
    }

    public function action(Instruction $instruction, Property $property)
    {
        $property->setDefault($instruction->getValues()[0]);
        return $property;
    }
}
