<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Entity;

use DominicLamb\EntityGenerator\Constraint\ConstraintInterface;

class Property
{
    private $constraints = [];
    private $default = null;
    private $name = '';
    private $type = null;
    private $isMutable = true;

    public function __construct(string $name) {
        $this->name = $name;
    }

    /**
     * @return ConstraintInterface[]
     */
    public function getConstraints() : array
    {
        return $this->constraints;
    }

    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Get the name of this property
     *
     * @return string Property name
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * Get the type of this property, or null if not present
     *
     * @return string|null
     */
    public function getType() : ?string {
        return $this->type;
    }

    public function addConstraint(ConstraintInterface $constraint)
    {
        if (isset($this->constraints[$constraint->getName()]))
        {
            throw new \InvalidArgumentException('Constraint ' . $constraint->getName() . ' already exists for ' .
            'property ' . $this->getName());
        }
        $this->constraints[$constraint->getName()] = $constraint;
    }
    public function setDefault($defaultValue)
    {
        $this->default = $defaultValue;
    }

    /**
     * Controls the mutability of this property.
     *
     * @param bool $mutable Property mutability.
     */
    public function setMutable(bool $mutable) : void
    {
        $this->isMutable = $mutable;
    }

    /**
     * Whether this property can be altered.
     *
     * @return bool Whether this property can be altered.
     */
    public function isMutable() : bool
    {
        return $this->isMutable;
    }
}