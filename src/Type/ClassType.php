<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

/**
 * A Class Type.
 */
class ClassType implements TypeInterface
{
    private \ReflectionClass $class;

    /**
     * Create a new ClassType.
     *
     * @param string $class The class name.
     * @throws \DomainException
     */
    public function __construct(string $class)
    {
        try {
            $this->class = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \DomainException("not a class name: \"{$class}\"");
        }
    }

    public function equals($value): bool
    {
        return $value instanceof self && $this->class->getName() == $value->class->getName();
    }

    public function is(TypeInterface $type): bool
    {
        return true;
    }

    public function isValueOfType($value): bool
    {
        return true;
    }
}
