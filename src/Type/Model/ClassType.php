<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Model;

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
     * @param \ReflectionClass $classReflection The Reflection of the class
     */
    public function __construct(\ReflectionClass $classReflection)
    {
        if ($classReflection->isInterface())
        {
            throw new \DomainException(
                'Expected a Class, but got an Interface instead.'
            );
        }
        parent::__construct($classReflection->getName());
        $this->classReflection = $classReflection;
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
