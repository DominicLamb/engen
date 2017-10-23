<?php
declare(strict_types = 1);

namespace DominicLamb\EntityGenerator\Parser;

/**
 * Parses lines in entity documentation, creating a set of instructions.
 *
 * @package DominicLamb\EntityGenerator\Parser
 */
class FileParser
{
    public function parse(string $path) : InstructionCollection
    {
        $contents = explode("\n", file_get_contents($path));
        $instructions = [];

        foreach($contents as $line)
        {
            $instructions[] = $this->readLine($line);
        }

        return new InstructionCollection(...$instructions);
    }

    private function readLine(string $line)
    {
        $commentsRemoved = $this->removeComments($line);
        return $this->createInstruction($commentsRemoved);
    }

    private function removeComments(string $line) : string
    {
        $length = strlen($line);
        $result = '';

        $withinValue = false;
        $withinComment = false;

        for ($position = 0; $position < $length; ++$position) {
            $char = $line[$position];

            if (!$withinValue && $char === '(') {
                $withinComment = true;
            }

            if (!$withinComment) {
                // Toggle value parsing if not within a comment.
                if ($char === '"') {
                    $withinValue = !$withinValue;
                }
                $result .= $char;
            }

            // A closing bracket ends comment mode.
            if ($withinComment && $char === ')') {
                $withinComment = false;
            }
        }

        if ($withinComment) {
            throw new InvalidSyntaxException('Unterminated comment.');
        }

        if ($withinValue) {
            throw new InvalidSyntaxException('Unterminated value.');
        }

        return $result;
    }

    private function createInstruction(string $text) : Instruction
    {
        $values = $this->extractValues($text);
        $matchText = $this->removeValues($text);

        $matchText = $this->normalizeMatchText($matchText);

        $instruction = new Instruction();
        $instruction->setText($matchText);
        $instruction->setValues($values);

        return $instruction;
    }

    private function extractValues(string $line) : array
    {
        $values = [];

        $length = strlen($line);

        $withinValue = false;
        $thisValue = '';

        for ($position = 0; $position < $length; ++$position) {
            $char = $line[$position];

            if ($char === '"') {
                if (!$withinValue) {
                    $withinValue = true;
                } else {
                    $values[] = $thisValue;
                    $thisValue = '';
                    $withinValue = false;
                }
            } elseif ($withinValue) {
                $thisValue .= $char;
            }
        }
        return $values;
    }

    private function removeValues(string $line) : string
    {
        $length = strlen($line);
        $withinValue = false;
        $result = '';

        for ($position = 0; $position < $length; ++$position) {
            $char = $line[$position];

            if ($char !== '"') {
                if (!$withinValue) {
                    $result .= $char;
                }
            } else {
                $withinValue = !$withinValue;
            }
        }

        return $result;
    }

    private function normalizeMatchText(string $text) : string
    {
        $matchText = preg_replace('/\s{2,}/', ' ', $text);
        $matchText = preg_replace('/\.$/', '', $matchText);
        $matchText = preg_replace('/(?:|^\s+|\s+$)/', '', $matchText);

        return $matchText;
    }
}