<?php
namespace PHP\Types;

/**
 * Store and retrieve type information for a class
 */
final class ClassType extends Type
{
    
    /**
     * Reflection instance with details about the class
     *
     * @var \ReflectionClass
     */
    private $class;
    
    
    /**
     * Create a new type instance representing a class
     *
     * @param \ReflectionClass $class Reflection instance for the class
     */
    public function __construct( \ReflectionClass $class )
    {
        parent::__construct( $class->getName() );
        $this->class = $class;
    }


    public function is( string $typeName ): bool
    {
        $typeName = trim( $typeName );
        return (
            ( $this->getName() === $typeName ) ||
            $this->class->isSubclassOf( $typeName )
        );
    }
}
