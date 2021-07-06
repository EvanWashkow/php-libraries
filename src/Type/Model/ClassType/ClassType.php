<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Model\ClassType;

use EvanWashkow\PhpLibraries\Exception\Logic\NotExistsException;
use EvanWashkow\PhpLibraries\Type\Model\Type;

/**
 * Defines a class type
 */
class ClassType extends Type
{
    /** @var \ReflectionClass The Reflection of the class */
    private $classReflection;


    /**
     * Creates a new ClassType for the given class
     *
     * @param string $className The class name
     */
    public function __construct(string $className)
    {
        // Set property
        if (!class_exists($className))
        {
            throw new NotExistsException("The class does not exist: \"{$className}\".");
        }
        $this->classReflection = new \ReflectionClass($className);

        // Call parent constructor
        parent::__construct($className);
    }


    final public function isValueOfType($value): bool
    {
        return is_a($value, $this->getName());
    }


    final protected function isOfType(Type $type): bool
    {
        return $this->isOfTypeName($type->getName());
    }


    final protected function isOfTypeName(string $typeName): bool
    {
        $isOfType = false;
        if (class_exists($typeName) || interface_exists($typeName)) {
            $isOfType = $this->getName() === $typeName ||
                $this->classReflection->isSubclassOf($typeName);
        }
        return $isOfType;
    }
}
