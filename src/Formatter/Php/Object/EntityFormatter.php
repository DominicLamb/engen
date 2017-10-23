<?php
declare(strict_types=1);

namespace DominicLamb\EntityGenerator\Formatter\Php\Object;

use DominicLamb\EntityGenerator\Entity\Entity;
use DominicLamb\EntityGenerator\Entity\Property;

class EntityFormatter
{
    public function format(Entity $entity)
    {
        $properties = $entity->getProperties();
        $result = '<?php' . "\n"
            . 'declare(strict_types = 1);' . "\n\n"
            . 'class ' . $entity->getName() . "\n"
            . '{' . "\n"
            . $this->renderProperties($properties);
        foreach ($properties as $property) {
            $result .= PropertyFormatter::format($property);
        }
        $result .= '}' . "\n";

        return $result;
    }

    /**
     * @param Property[] $properties
     *
     * @return string
     */
    private function renderProperties(array $properties) : string
    {
        $result = '';

        foreach ($properties as $property) {
            $defaultValue = '';
            $propertyName = $property->getName();
            // Camelcase-ish
            $propertyName[0] = strtolower($propertyName[0]);
            $result .= '    private $' . $propertyName;

            if ($property->getDefault() !== null) {
                if (is_string($property->getDefault())) {
                    $defaultValue = '"' . $property->getDefault() . '"';
                } elseif (is_array($property->getDefault())) {
                    $defaultValue = '[]';
                }
                $result .= ' = ' . $defaultValue;
            }
            $result .= ";\n";
        }

        return $result;
    }
}