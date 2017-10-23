<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Parser;

use DominicLamb\EntityGenerator\Entity\Entity;
use DominicLamb\EntityGenerator\Entity\Property;
use DominicLamb\EntityGenerator\Matcher\BetweenCharacterLength;
use DominicLamb\EntityGenerator\Matcher\CreateEntity;
use DominicLamb\EntityGenerator\Matcher\CreateListProperty;
use DominicLamb\EntityGenerator\Matcher\CreateProperty;
use DominicLamb\EntityGenerator\Matcher\DefaultValue;
use DominicLamb\EntityGenerator\Matcher\IsImmutable;
use DominicLamb\EntityGenerator\Matcher\MatcherInterface;

class Generator
{
    private $matchers = [];

    /**
     * Generate an Entity from an Instruction list.
     *
     * @param \Iterator $instructions Stateful instruction list.
     *
     * @return Entity Processed entity.
     */
    public function generate(\Iterator $instructions, $context = null)
    {
        $this->matchers = $this->getMatchers();
        $activeProperty = null;

        foreach ($instructions as $instruction) {
            if($instruction->getText()) {
                $match = $this->getMatch($instruction);

                if ($match) {
                    if (!$match->validate($instruction)) {
                        throw new \DomainException('Invalid values for Instruction: ' . $instruction->getText());
                    }

                    if ($match->isNewContext()) {
                        $instructions->next();
                        if ($context) {
                            $this->generate($instructions, $match->action($instruction, $context));
                        } else {
                            $context = $match->action($instruction);
                        }
                    } else {
                        $context = $match->action($instruction, $context);
                    }
                } else {
                    throw new \DomainException('Unrecognised Instruction: ' . $instruction->getText());
                }
            } elseif ($context && !($context instanceof Entity)) {
                return;
            }
        }

        return $context;
    }

    private function getMatchers() : array
    {
        return [
            new CreateEntity(),
            new CreateListProperty(),
            new CreateProperty(),
            new BetweenCharacterLength(),
            new DefaultValue(),
            new IsImmutable()
        ];
    }

    private function getMatch(Instruction $instruction) : ?MatcherInterface
    {
        $matcher = null;
        foreach ($this->matchers as $matcher) {
            if ($matcher->match($instruction->getText())) {
                return $matcher;
            }
        }

        return null;
    }
}