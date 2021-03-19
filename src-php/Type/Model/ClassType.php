<?php
declare(strict_types=1);

namespace PHP\Type\Model;

/**
 * Defines a class type
 */
class ClassType extends Type
{
    /** @var \ReflectionClass The Reflection of the class */
    private $reflectionClass;


    /**
     * Creates a new ClassType for the given class
     *
     * @param \ReflectionClass $reflectionClass The Reflection of the class
     */
    public function __construct(\ReflectionClass $reflectionClass)
    {
        parent::__construct($reflectionClass->getName());
        $this->reflectionClass = $reflectionClass;
    }

    public function isValueOfType($value): bool
    {
        return is_subclass_of($value, $this->getName());
    }

    protected function isOfType(Type $type): bool
    {
        $isClass = $type instanceof ClassType;
        return $isClass && $this->reflectionClass->isSubclassOf($type->getName());
    }

    protected function isOfTypeName(string $typeName): bool
    {
        $isClassOrInterface = class_exists($typeName) || interface_exists($typeName);
        return $isClassOrInterface && $this->reflectionClass->isSubclassOf($typeName);
    }
}
