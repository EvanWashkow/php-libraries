<?php
namespace PHP\Types\Models;

use PHP\Collections\Sequence;

/**
 * Defines an interface for types
 */
interface IType
{
    /**
     * Retrieve the primary type name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Retrieve all known names for this type
     *
     * @return Sequence
     */
    public function getNames(): Sequence;

    /**
     * Determine if the type or value is derived from the current type
     *
     * @param mixed $item A value or PHP\Types\Models\Type instance
     * @return bool
     */
    public function equals( $item ): bool;

    /**
     * Determine if this type is derived from the given type
     * 
     * @internal Type comparison cannot reference collections: collections rely
     * on type comparison.
     *
     * @param string $typeName The type to compare this type with
     **/
    public function is( string $typeName ): bool;
    
    /**
     * Determine if this type is a class
     *
     * @return bool
     **/
    public function isClass(): bool;

    /**
     * Determine if this type is an interface
     *
     * @return bool
     **/
    public function isInterface(): bool;
}