<?php
namespace PHP\Types;

/**
 * Defines basic type information
 */
class Type extends \PHP\PHPObject
{
    /**
     * The type name
     *
     * @var string
     */
    private $name;
    
    /**
     * Create a Type representation to retrieve information from
     *
     * @param string $name The type name
     */
    public function __construct( string $name )
    {
        $this->name = trim( $name );
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
