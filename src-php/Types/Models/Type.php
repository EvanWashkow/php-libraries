<?php

declare(strict_types=1);

namespace PHP\Types\Models;

use PHP\Collections\ByteArray;
use PHP\Collections\Sequence;
use PHP\ObjectClass;

/**
 * Retrieve information for a system type.
 */
class Type extends ObjectClass
{
    // PROPERTIES

    /** @var string The primary type name */
    private $name;

    /** @var string[] All names for this type. For internal use. */
    private $namesArray;

    /** @var Sequence All known names for this type. For external use. */
    private $namesSequence;

    // CONSTRUCTOR

    /**
     * Create a type representation to retrieve information from.
     *
     * @internal do not instantiantiate collections in the type constructor:
     * collections rely on types
     *
     * @param string   $name    The primary type name
     * @param string[] $aliases Alternate names for this type
     *
     * @throws \DomainException
     */
    public function __construct(string $name, array $aliases = [])
    {
        // Set name
        if ('' === ($name = trim($name))) {
            throw new \DomainException('Type name cannot be empty');
        }

        // Set properties
        $this->name = $name;
        $this->namesArray = $aliases;
        if (!in_array($name, $this->namesArray)) {
            array_splice($this->namesArray, 0, 0, $name);
        }
        $this->namesSequence = null;
    }

    // ACCESSORS

    /**
     * Retrieve the primary type name.
     *
     * @internal final: this type name cannot be changed
     */
    final public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieve all known names for this type.
     *
     * @internal final: the list of type names cannot be changed
     */
    final public function getNames(): Sequence
    {
        if (null === $this->namesSequence) {
            $this->namesSequence = new Sequence('string', $this->namesArray);
        }

        return $this->namesSequence->clone();
    }

    // COMPARISON

    public function hash(): ByteArray
    {
        return new ByteArray($this->getName());
    }

    /**
     * Determines Type equality.
     *
     * equals(Type $type): Determines if this Type is equal to another Type
     *
     * equals($value): Determines if a value is of this Type
     *
     * @param mixed $value The value to compare to (see method documentation)
     */
    public function equals($value): bool
    {
        $isEqual = false;
        if ($value instanceof Type) {
            $isEqual = $this->getName() === $value->getName();
        }

        return $isEqual;
    }

    /**
     * Determine if this type is (derived from) the given type.
     *
     * i.e. This type has all the same properties and methods as the given type;
     * meaning this type >= that type.
     *
     * @internal type comparison cannot reference collections: collections rely
     * on type comparison
     *
     * @param string $typeName The type to compare this type with
     */
    public function is(string $typeName): bool
    {
        return in_array($typeName, $this->namesArray, true);
    }

    /**
     * Determine if this type is a class.
     */
    public function isClass(): bool
    {
        return false;
    }

    /**
     * Determine if this type is an interface.
     */
    public function isInterface(): bool
    {
        return false;
    }

    /**
     * Determines if the value is of this Type.
     *
     * @param mixed $value The value to compare
     */
    public function isValueOfType($value): bool
    {
        return is($value, $this->getName());
    }
}
