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

    /** @var ReadOnlySequence $aliases Alternate names for this type */
    private $aliases;

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

        /**
         * IMPORTANT!!! ALIAS SEQUENCE CANNOT BE TYPED!!!
         * Adding an alias string to a typed Collection causes the Collection to
         * evaluate the Type of that string. However, aliases themselves are
         * used when comparing Types. This is a paradox and will result in
         * infinite recursion unless an untyped Collection is used. (Untyped
         * collections do not evaluate aliases).
         */
        $this->aliases = new Sequence();
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
