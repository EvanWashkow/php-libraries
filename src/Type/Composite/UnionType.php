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
     * @param Type $typeA The first type for this union
     * @param Type $typeB The second type for this union
     * @param Type ...$additionalTypes Any additional types for this union
     */
    public function __construct(Type $typeA, Type $typeB, Type ...$additionalTypes)
    {
        // Set types property
        $this->types = array_merge(
            [
                $typeA,
                $typeB
            ],
            $additionalTypes
        );

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
