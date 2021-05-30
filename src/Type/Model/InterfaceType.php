<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Model;

/**
 * Defines an interface type
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
        if (!$interfaceReflection->isInterface())
        {
            throw new \DomainException(
                'Expected an Interface, but got a Class instead.'
            );
        }
        parent::__construct($interfaceReflection->getName());
        $this->interfaceReflection = $interfaceReflection;
    }


    final public function isValueOfType($value): bool
    {
        return is_subclass_of($value, $this->getName());
    }


    final protected function isOfType(Type $type): bool
    {
        return $this->isOfTypeName($type->getName());
    }

    
    final protected function isOfTypeName(string $typeName): bool
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
