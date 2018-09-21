<?php
namespace PHP\Types;

use PHP\Collections\ReadOnlySequence;
use PHP\Collections\Sequence;

/**
 * Defines basic type information
 */
class Type extends \PHP\PHPObject
{
    
    /***************************************************************************
    *                                  VARIABLES
    ***************************************************************************/
    
    /**
     * Alternate names for this type
     *
     * @var ReadOnlySequence
     */
    private $aliases;
    
    /**
     * The type name
     *
     * @var string
     */
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
        $this->name    = trim( $name );
        $this->aliases = new Sequence( 'string' );
        foreach ( $aliases as $alias ) {
            $this->aliases->add( $alias );
        }
        $this->aliases = new ReadOnlySequence( $this->aliases );
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
        return $this->aliases;
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
        // Get a Type instance
        // TODO Use \PHP\Types::GetByValue() to determine if the item is a Type instance
        $itemType = null;
        if ( is_a( $item, self::class ) ) {
            $itemType = $item;
        }
        else {
            $itemType = \PHP\Types::GetByValue( $item );
        }
        
        // If the type names match, this is the same type
        return $this->getName() === $itemType->getName();
    }
    
    
    /**
     * Determine if this type is derived from that type
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
