<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

use PHP\Collections\Sequence;
use PHP\ObjectClass;
use SebastianBergmann\ObjectReflector\InvalidArgumentException;

/**
 * Retrieve information for a system type
 */
class Type extends ObjectClass
{
    
    /*******************************************************************************************************************
    *                                                      PROPERTIES
    *******************************************************************************************************************/

    /** @var string $name The primary type name */
    private $name;

    /** @var string[] $namesArray All names for this type. For internal use. */
    private $namesArray;

    /** @var Sequence $namesSequence All known names for this type. For external use. */
    private $namesSequence;




    /*******************************************************************************************************************
    *                                                      CONSTRUCTOR
    *******************************************************************************************************************/
    
    
    /**
     * Create a type representation to retrieve information from
     * 
     * @internal Do not instantiantiate collections in the type constructor:
     * collections rely on types.
     *
     * @param string   $name    The primary type name
     * @param string[] $aliases Alternate names for this type
     * @throws \DomainException
     */
    public function __construct( string $name, array $aliases = [] )
    {
        // Set name
        if ( '' === ( $name = trim( $name ) )) {
            throw new \DomainException( 'Type name cannot be empty' );
        }
        
        // Set properties
        $this->name       = $name;
        $this->namesArray = $aliases;
        if ( !in_array( $name, $this->namesArray )) {
            array_splice( $this->namesArray, 0, 0, $name );
        }
        $this->namesSequence = null;
    }
    
    
    
    
    /*******************************************************************************************************************
    *                                                       ACCESSORS
    *******************************************************************************************************************/
    
    
    /**
     * Retrieve the primary type name
     * 
     * @internal Final: this type name cannot be changed.
     *
     * @return string
     */
    final public function getName(): string
    {
        return $this->name;
    }
    
    
    /**
     * Retrieve all known names for this type
     * 
     * @internal Final: the list of type names cannot be changed.
     *
     * @return Sequence
     */
    final public function getNames(): Sequence
    {
        if ( null === $this->namesSequence ) {
            $this->namesSequence = new Sequence( 'string', $this->namesArray );
        }
        return $this->namesSequence->clone();
    }
    
    
    
    
    /*******************************************************************************************************************
    *                                                     COMPARISON
    *******************************************************************************************************************/
    
    
    /**
     * Determine if the type or value is (derived from) this type
     * 
     * i.e. The given type must have all the same properties and methods;
     * meaning this type <= that type.
     *
     * @param mixed $value A value or PHP\Types\Models\Type instance
     * @return bool
     */
    public function equals($value): bool
    {
        $equals = null;
        if ($value instanceof Type) {
            $equals = $this->equalsType($value);
        }
        else {
            $equals = $this->equalsValue($value);
        }
        return $equals;
    }


    /**
     * Determines if this Type equals another Type
     *
     * @param Type $type The Type to compare
     * @return bool
     */
    private function equalsType(Type $type): bool
    {
        return $type->is($this->getName());
    }


    /**
     * Determines if the value is of this Type
     *
     * @param mixed $value The value to compare
     * @return bool
     */
    private function equalsValue($value): bool
    {
        return is($value, $this->getName());
    }


    /**
     * Determine if this type is (derived from) the given type
     *
     * i.e. This type has all the same properties and methods as the given type;
     * meaning this type >= that type.
     * 
     * @internal Type comparison cannot reference collections: collections rely
     * on type comparison.
     *
     * @param string $typeName The type to compare this type with
     * @return bool
     */
    public function is( string $typeName ): bool
    {
        return in_array( $typeName, $this->namesArray, true );
    }
    

    /**
     * Determine if this type is a class
     *
     * @return bool
     **/
    public function isClass(): bool
    {
        return false;
    }
    
    
    /**
     * Determine if this type is an interface
     *
     * @return bool
     **/
    public function isInterface(): bool
    {
        return false;
    }
}
