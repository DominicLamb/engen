<?php
declare(strict_types = 1);

namespace DominicLamb\EntityGenerator\Parser;

/**
 * Represents an instruction for entity generation.
 *
 * @package DominicLamb\EntityGenerator\Parser
 */
class Instruction
{
    /** @var string The matched instruction text. */
    private $text;

    /** @var array List of values identified within the instruction. */
    private $values = [];

    /**
     * Get the matched instruction text.
     *
     * @return string Instruction.
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * Get the list of identified values.
     *
     * @return array Value list.
     */
    public function getValues() : array
    {
        return $this->values;
    }

    /**
     * Set the matched instruction text.
     *
     * @param string $text Instruction.
     *
     * @return void
     */
    public function setText(string $text) : void
    {
        $this->text = $text;
    }

    /**
     * Add a set of values to this instruction.
     *
     * @param array $values Instruction values.
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
    }
}