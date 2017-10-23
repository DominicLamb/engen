<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Formatter\Php\Object;

use DominicLamb\EntityGenerator\Entity\Property;

class PropertyFormatter
{
    public static function format(Property $property) : string
    {
        $result = self::generateGetter($property);
        if ($property->isMutable()) {
            $result .= self::generateSetter($property);
        }

        return $result . "\n";
    }

    public static function generateGetter(Property $property) : string
    {
        $propertyName = $property->getName();
        $propertyName[0] = strtolower($propertyName[0]);

        $result = '    public function get' . $property->getName() . '()' . "\n";
        $result .= '    {' . "\n";
        $result .= '        return $this->' . $propertyName . ';' . "\n";
        $result .= '    }' . "\n";

        return $result;
    }

    public static function generateSetter(Property $property) : string
    {
        $propertyName = $property->getName();
        $propertyName[0] = strtolower($propertyName[0]);

        $result = self::formatSetterSignature($property);
        $result .= '    {' . "\n";
        $result .= self::formatConstraints($property);
        $result .= '        $this->' . $propertyName . ' = $value;' . "\n";
        $result .= '    }' . "\n";

        return $result;
    }

    private static function formatSetterSignature(Property $property)
    {
        $result = '    private function set' . $property->getName() . '(';
        if ($property->getType()) {
            $result .= $property->getType() . ' ';
        }
        $result .= '$value)' . "\n";

        return $result;
    }

    private static function formatConstraints(Property $property) : string
    {
        $propertyConstraints = $property->getConstraints();
        $constraints = [];
        $result = '';
        if ($propertyConstraints) {
            $result .= '        if (';
            foreach ($propertyConstraints as $constraint) {
                $constraints[] = '(' . ConstraintFormatter::format($constraint) . ')';
            }
            $result .= implode(' && ', $constraints);
            $result .= ') {' . "\n";
            $result .= '            throw new \InvalidArgumentException(\'BAD\');' . "\n";
            $result .= '        }' . "\n";
        }

        return $result;
    }
}