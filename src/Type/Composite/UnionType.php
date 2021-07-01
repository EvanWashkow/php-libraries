<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Type\Composite;

use EvanWashkow\PhpLibraries\Type\Type;

/**
 * Defines a Union Type
 *
 * Example: string|int is a union type that permits either a string or an integer value.
 */
class UnionType extends Type
{

    /** @var Type[] The types for this union */
    private $types;


    /**
     * Creates a new UnionType instance
     *
     * @param Type $type The types for this union (there must be at least one)
     * @param Type ...$types The types for this union
     */
    public function __construct(Type $type, Type ...$types)
    {
        // Set properties
        $this->types = array_merge([$type], $types);

        // Call parent constructor
        $names = [];
        foreach ($this->types as $type)
        {
            $names[] = $type->getName();
        }
        parent::__construct(implode('|', $names));
    }


    /**
     * @inheritDoc
     */
    public function isValueOfType($value): bool
    {
        foreach ($this->types as $type)
        {
            if ($type->isValueOfType($value))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function isOfType(Type $type): bool
    {
        // TODO: Implement isOfType() method.
    }

    /**
     * @inheritDoc
     */
    protected function isOfTypeName(string $typeName): bool
    {
        // TODO: Implement isOfTypeName() method.
    }
}
