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
     * Short variant of the type name
     *
     * @var string
     */
    private $shortName;
    
    
    /**
     * Create a Type representation to retrieve information from
     *
     * @param string $name      The type name
     * @param string $shortName Short variant of the type name
     */
    public function __construct( string $name, string $shortName = '' )
    {
        $this->name      = trim( $name );
        $this->shortName = trim( $shortName );
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
    
    
    /**
     * Retrieve the short variant of the type name
     *
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }
}
