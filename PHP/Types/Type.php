<?php
namespace PHP\Types;

use PHP\Collections\ReadOnlySequence;
use PHP\Collections\Sequence;

/**
 * Defines basic type information
 */
class Type extends \PHP\PHPObject
{
    
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
    
    
    /**
     * Determines if the given value or PHP\Types\Type instance is, or is
     * derived from, this type
     *
     * @param mixed $item A value or PHP\Types\Type instance
     * @return bool
     */
    public function equals( $item ): bool
    {
        // Get a Type instance
        // TODO Use \PHP\Types::GetByValue() to determine if the item is a Type instance
        $itemType = null;
        if ( self::class === get_class( $item ) || is_subclass_of( $item, self::class )) {
            $itemType = $item;
        }
        else {
            $itemType = \PHP\Types::GetByValue( $item );
        }
        
        // If the type names match, this is the same type
        return $this->getName() === $itemType->getName();
    }
    
    
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
}
