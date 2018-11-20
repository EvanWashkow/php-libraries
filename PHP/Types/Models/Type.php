<?php
namespace PHP\Types\Models;

use PHP\Collections\ReadOnlySequence;
use SebastianBergmann\ObjectReflector\InvalidArgumentException;
use PHP\Collections\Sequence;

/**
 * Defines basic type information
 */
class Type implements IType
{
    
    /***************************************************************************
    *                                  PROPERTIES
    ***************************************************************************/

    /** @var string $name The primary type name */
    private $name;

    /** @var string[] $namesArray All names for this type. For internal use. */
    private $namesArray;

    /** @var Sequence $namesSequence All known names for this type. For external use. */
    private $namesSequence;




    /***************************************************************************
    *                                 CONSTRUCTOR
    ***************************************************************************/
    
    
    /**
     * Create a Type representation to retrieve information from
     * 
     * @internal Do not instantiantiate collections in the type constructor:
     * collections rely on types.
     *
     * @param string   $name    The primary type name
     * @param string[] $aliases Alternate names for this type
     */
    public function __construct( string $name, array $aliases = [] )
    {
        // Set name
        if ( '' === ( $name = trim( $name ) )) {
            throw new InvalidArgumentException( 'Type name cannot be empty' );
        }
        
        // Set properties
        $this->name       = $name;
        $this->namesArray = $aliases;
        if ( !in_array( $name, $this->namesArray )) {
            array_splice( $this->namesArray, 0, 0, $name );
        }
        $this->namesSequence = null;
    }
    
    
    
    
    /***************************************************************************
    *                                   ACCESSORS
    ***************************************************************************/
    
    
    /**
     * @see IType->getName()
     */
    final public function getName(): string
    {
        return $this->name;
    }
    
    
    /**
     * @see IType->getNames()
     */
    final public function getNames(): Sequence
    {
        // Build the name sequence
        if ( null === $this->namesSequence ) {
            $this->namesSequence = new Sequence( 'string' );
            foreach ( $this->namesArray as $name ) {
                $this->namesSequence->add( $name );
            }
        }

        // Return sequence of names
        return $this->namesSequence->clone();
    }
    
    
    
    
    /***************************************************************************
    *                                 COMPARISON
    ***************************************************************************/
    
    
    /**
     * @see IType->equals()
     */
    public function equals( $item ): bool
    {
        // Get the item type
        $type = \PHP\Types::GetByValue( $item );

        // The item is a Type instance. Evaluate the item as the Type.
        if ( $type->is( self::class )) {
            $type = $item;
        }
        
        // Determine if that type is derived from this one
        return $type->is( $this->getName() );
    }
    
    
    /**
     * @see IType->is()
     */
    public function is( string $typeName ): bool
    {
        return in_array( $typeName, $this->namesArray );
    }
    

    /**
     * @see IType->isClass()
     */
    public function isClass(): bool
    {
        return false;
    }
    
    
    /**
     * @see IType->isInterface()
     */
    public function isInterface(): bool
    {
        return false;
    }
}
