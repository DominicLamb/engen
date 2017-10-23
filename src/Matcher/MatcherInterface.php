<?php

namespace DominicLamb\EntityGenerator\Matcher;

interface MatcherInterface
{
    const TARGET_ENTITY = 'entity';
    const TARGET_PROPERTY = 'property';

    public function match(string $text) : bool;
    public function isNewContext() : bool;
    public function getTarget() : string;
}