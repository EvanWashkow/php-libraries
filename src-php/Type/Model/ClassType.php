<?php
declare(strict_types = 1);

namespace PHP\Type\Model;

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
        parent::__construct($classReflection->getName());
        $this->classReflection = $classReflection;
    }

    public function isValueOfType($value): bool
    {
        return is_a($value, $this->getName());
    }

    protected function isOfType(Type $type): bool
    {
        return $this->isOfTypeName($type->getName());
    }

    protected function isOfTypeName(string $typeName): bool
    {
        $isOfType = false;
        if (class_exists($typeName) || interface_exists($typeName)) {
            $isOfType = $this->getName() === $typeName ||
                $this->classReflection->isSubclassOf($typeName);
        }
        return $isOfType;
    }
}
