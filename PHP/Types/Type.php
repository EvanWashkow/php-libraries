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
     * Retrieve alternate names for this type
     *
     * @return ReadOnlySequence
     */
    public function getAliases(): ReadOnlySequence
    {
        return $this->aliases;
    }
    
    
    /**
     * Retrieve the full type name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
