<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

use PHP\Collections\Dictionary;

/**
 * Store and retrieve type information for a interface
 */
class InterfaceType extends Type
{

    /***************************************************************************
    *                                 PROPERTIES
    ***************************************************************************/


    /** @var Dictionary $constants The constants belonging to this Interface */
    private $constants;

    /**  @var \ReflectionClass Reflection instance containing details about the interface */
    private $reflectionClass;




    /***************************************************************************
    *                                  CONSTRUCTOR
    ***************************************************************************/


    /**
     * Create a new type instance representing a interface
     *
     * @param \ReflectionClass $reflectionClass ReflectionClass instance
     */
    public function __construct( \ReflectionClass $reflectionClass )
    {
        // Set primary properties
        $this->reflectionClass = $reflectionClass;
        parent::__construct( $this->reflectionClass->getName() );

        // Set lazy-loaded properties
        $this->constants = null;
    }




    /***************************************************************************
    *                                OWN ACCESSORS
    ***************************************************************************/


    /**
     * Retrieve the constants as key => value pairs, where the key is the
     * constant name, and value is the constant value.
     * 
     * @return \Dictionary
     */
    public function getConstants(): Dictionary
    {
        if ( null === $this->constants ) {
            $this->constants = new Dictionary(
                'string',
                '*',
                $this->getReflectionClass()->getConstants()
            );
        }
        return $this->constants;
    }


    /**
     * Retrieve the reflection class instance
     * 
     * @internal Final: there's really nothing more to do here.
     *
     * @return \ReflectionClass
     **/
    final protected function getReflectionClass(): \ReflectionClass
    {
        return $this->reflectionClass;
    }




    /***************************************************************************
    *                                BASE OVERRIDES
    ***************************************************************************/


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


    /**
     * @see parent::isInterface()
     */
    public function isInterface(): bool
    {
        return true;
    }
}
