<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Model\InterfaceType;

use EvanWashkow\PhpLibraries\Exception\Logic\NotExistsException;
use EvanWashkow\PhpLibraries\Type\Model\Type;

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
     * @param string $interfaceName The interface name
     */
    public function __construct(string $interfaceName)
    {
        // Set property
        if (!interface_exists($interfaceName))
        {
            throw new NotExistsException("The interface does not exist: \"{$interfaceName}\".");
        }
        $this->interfaceReflection = new \ReflectionClass($interfaceName);

        // Call parent constructor
        parent::__construct($interfaceName);
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
