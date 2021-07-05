<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Type\Model\Composite;

use EvanWashkow\PhpLibraries\Type\Model\Type;

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
     *
     * @returns bool True if the value is at least one of these types. False otherwise.
     */
    final public function isValueOfType($value): bool
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
     *
     * @internal Returns whether all the types in this union are of the given type. For example, (int|string)->is(int)
     * is false, because a string is not an integer. However, given a union where both classes A and B implement
     * interface I; (A|B)->is(I) should return true.
     *
     * @returns bool True if every type in this union is of the given type. False otherwise.
     */
    final protected function isOfType(Type $type): bool
    {
        return $this->isOfTypeName($type->getName());
    }

    /**
     * @inheritDoc
     *
     * @internal See isOfType().
     *
     * @returns bool True if every type in this union is of the given type. False otherwise.
     */
    final protected function isOfTypeName(string $typeName): bool
    {
        foreach ($this->types as $type)
        {
            if (!$type->is($typeName))
            {
                return false;
            }
        }
        return true;
    }
}
