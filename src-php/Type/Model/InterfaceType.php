<?php
declare(strict_types = 1);

namespace PHP\Type\Model;

use phpDocumentor\Reflection\Types\Self_;

/**
 * Defines a interface type
 */
class InterfaceType extends Type
{
    /** @var \ReflectionClass The Reflection of the interface */
    private $interfaceReflection;


    /**
     * Creates a new InterfaceType for the given interface
     *
     * @param \ReflectionClass $interfaceReflection The Reflection of the interface
     */
    public function __construct(\ReflectionClass $interfaceReflection)
    {
        parent::__construct($interfaceReflection->getName());
        $this->interfaceReflection = $interfaceReflection;
    }

    public function isValueOfType($value): bool
    {
        return false;
    }

    protected function isOfType(Type $type): bool
    {
        return $this->isOfTypeName($type->getName());
    }

    protected function isOfTypeName(string $typeName): bool
    {
        $isOfType = false;
        if (interface_exists($typeName))
        {
            $isOfType = $this->getName() === $typeName ||
                $this->interfaceReflection->isSubclassOf($typeName);
        }
        return $isOfType;
    }
}
