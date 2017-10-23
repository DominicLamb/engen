<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Parser;

class InstructionCollection
{
    private $instructions;

    public function __construct(Instruction ...$instructions)
    {
        $this->instructions = $instructions;
    }

    public function getIterator() : \NoRewindIterator
    {
        return new \NoRewindIterator(new \ArrayIterator($this->instructions));
    }
}