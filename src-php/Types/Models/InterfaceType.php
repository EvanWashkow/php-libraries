<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

/**
 * Retrieve type information for a interface
 */
class InterfaceType extends Type implements \Serializable
{
    
    /**
     * Reflection instance with details about the interface
     *
     * @var \ReflectionClass
     */
    private $reflectionClass;
    
    
    /**
     * Create an interface representation to retrieve information from
     *
     * @param \ReflectionClass $reflectionClass ReflectionClass instance
     */
    public function __construct( \ReflectionClass $reflectionClass )
    {
        $this->reflectionClass = $reflectionClass;
        parent::__construct( $this->reflectionClass->getName() );
    }


    /**
     * @internal Final: there is no more to add to this method.
     */
    final public function is( string $typeName ): bool
    {
        return (
            ( $this->getName() === $typeName ) ||

            /**
             * is_subclass_of() tends to be just slightly faster than
             * $this->getReflectionClass()->isSubClassOf()
             */
            is_subclass_of( $this->getName(), $typeName )
        );
    }
    
    
    public function isInterface(): bool
    {
        return true;
    }


    public function serialize(): string
    {
        return $this->reflectionClass->getName();
    }


    public function unserialize($data)
    {
        $this->__construct(new \ReflectionClass($data));
    }


    /**
     * Retrieve the reflection class instance
     *
     * @return \ReflectionClass
     **/
    protected function getReflectionClass(): \ReflectionClass
    {
        return $this->reflectionClass;
    }
}
