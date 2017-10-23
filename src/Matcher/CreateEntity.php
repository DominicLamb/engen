<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Matcher;

use DominicLamb\EntityGenerator\Entity\Entity;
use DominicLamb\EntityGenerator\Parser\Instruction;

class CreateEntity implements MatcherInterface
{
    public function match(string $string) : bool
    {
        return (bool) preg_match('/^This is a/', $string);
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

    public function action(Instruction $instruction)
    {
        $entity = new Entity();
        $name = $entity->getName();
        if ($name) {
            throw new \DomainException('Cannot rename Entity.');
        }
        $entity->setName($instruction->getValues()[0]);

        return $entity;
    }
}
