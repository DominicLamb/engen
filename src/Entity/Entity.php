<?php
declare(strict_types=1);
namespace DominicLamb\EntityGenerator\Entity;

class Entity
{
    private $name = '';
    private $properties = [];

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getProperties() : array
    {
        return $this->properties;
    }

    public function addProperty(Property $property)
    {
        if (isset($this->properties[$property->getName()])) {
            throw new \DomainException('Property ' . $property->getName() . ' cannot be redefined.');
        }

        $this->properties[$property->getName()] = $property;
    }
}