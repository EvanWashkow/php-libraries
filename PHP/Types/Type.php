<?php
namespace PHP\Types;

use PHP\Collections\ReadOnlySequence;
use SebastianBergmann\ObjectReflector\InvalidArgumentException;

/**
 * Defines basic type information
 */
class Type extends \PHP\PHPObject
{
    
    /***************************************************************************
    *                                  VARIABLES
    ***************************************************************************/

    /** @var ReadOnlySequence $aliasArray Alternate names for this type */
    private $aliasArray;

    /** @var ReadOnlySequence $aliasROS Alternate names for this type */
    private $aliasROS;

    /** @var string $name The type name */
    private $name;




    /***************************************************************************
    *                                 CONSTRUCTOR
    ***************************************************************************/
    
    
    /**
     * Create a Type representation to retrieve information from
     *
     * @param string   $name    The type name
     * @param string[] $aliases Alternate names for this type
     */
    public function __construct( string $name, array $aliases = [] )
    {
        $this->name = trim( $name );
        if ( $this->name === '' ) {
            throw new InvalidArgumentException( 'Type name cannot be empty' );
        }

        /**
         * IMPORTANT! DO NOT CREATE ALIAS SEQUENCE IN THE CONSTRUCTOR!
         * 
         * Collections depend on type comparison. Type comparison relies on
         * Collections for aliases. Initializing the alias collection in the
         * constructor will result in infinite recursion.
         */
        $this->aliasArray = $aliases;
        $this->aliasROS   = null;
    }
    
    
    
    
    /***************************************************************************
    *                                   PROPERTIES
    ***************************************************************************/
    
    
    /**
     * Retrieve alternate names for this type
     *
     * @return ReadOnlySequence
     */
    final public function getAliases(): ReadOnlySequence
    {
        /**
         * Build alias sequence. See documentation in constructor.
         * 
         * IMPORTANT! ALIAS SEQUENCE CANNOT BE TYPED!
         * 
         * A typed alias sequence would rely on a type comparison using a typed
         * alias sequence. This would result in infinite recursion.
         * An untyped alias sequence adds items without looking at type aliases.
         */
        if ( null === $this->aliasROS ) {
            $sequence = new \PHP\Collections\Sequence();
            foreach ( $this->aliasArray as $alias ) {
                $sequence->add( $alias );
            }
            $this->aliasROS = new ReadOnlySequence( $sequence );
        }

        // Return read-only sequence of aliases
        return $this->aliasROS;
    }
    
    
    /**
     * Retrieve the full type name
     *
     * @return string
     */
    final public function getName(): string
    {
        return $this->name;
    }
    
    
    
    
    /***************************************************************************
    *                                 COMPARISON
    ***************************************************************************/
    
    
    /**
     * Determine if the type or value is derived from the current type
     *
     * @param mixed $item A value or PHP\Types\Type instance
     * @return bool
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
     * Determine if this type is derived from the given type
     *
     * @param string $typeName The type to compare this type with
     **/
    public function is( string $typeName ): bool
    {
        return (
            ( $this->getName() === $typeName ) ||
            ( 0 <= $this->getAliases()->getKeyOf( $typeName ) )
        );
    }
}
