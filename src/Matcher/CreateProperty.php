<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Matcher;

use DominicLamb\EntityGenerator\Entity\Entity;
use DominicLamb\EntityGenerator\Entity\Property;
use DominicLamb\EntityGenerator\Parser\Instruction;

class CreateProperty implements MatcherInterface
{
    public function match(string $string) : bool
    {
        return (bool) preg_match('/^It has a/', $string);
    }

    public function isNewContext() : bool
    {
        return true;
    }

    public function getTarget() : string
    {
        return self::TARGET_ENTITY;
    }

    public function validate(Instruction $instruction)
    {
        return count($instruction->getValues()) === 1;
    }

    public function action(Instruction $instruction, Entity $entity)
    {
        $name = $instruction->getValues()[0];
        $property = new Property($name);

        $entity->addProperty($property);
        return $property;
    }
}
