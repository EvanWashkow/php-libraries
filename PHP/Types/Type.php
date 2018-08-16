<?php
namespace PHP\Types;

/**
 * Defines basic type information
 */
class Type extends \PHP\PHPObject
{
    
    /**
     * Alternate names for this type
     *
     * @var array
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
     * @param string $name    The type name
     * @param array  $aliases Alternate names for this type
     */
    public function __construct( string $name, array $aliases = [] )
    {
        $this->name    = trim( $name );
        $this->aliases = $aliases;
    }
    
    
    /**
     * Retrieve alternate names for this type
     *
     * @return array
     */
    public function getAliases(): array
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
