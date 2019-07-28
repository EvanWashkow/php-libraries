<?php
declare( strict_types = 1 );

namespace PHP\Enums;

use PHP\ObjectClass;

/**
 * Allows users to define (and select from) a strict set of constant values
 * 
 * @internal Defaults must be defined and handled in the child class.
 */
abstract class Enum extends ObjectClass
{

    /** @var mixed $value The current value in this set of enumerated constants */
    private $value;


    /**
     * Create a new Enumeration instance
     *
     * @param mixed $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not in the set of enumerated constants
     **/
    public function __construct( $value )
    {
        try {
            $this->setValue( $value );
        } catch ( \DomainException $e ) {
            throw new \DomainException( $e->getMessage(), $e->getCode(), $e->getPrevious() );
        }
    }


    /**
     * Retrieve the current value
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Set the current value
     * 
     * @internal By default, this is not publicly-accessible since oftentimes
     * immutibility is desired.
     * 
     * @param mixed $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not in the set of enumerated constants
     */
    protected function setValue( $value )
    {
        $constants = ( new \ReflectionClass( $this ) )->getConstants();
        if ( !in_array( $value, $constants, true )) {
            throw new \DomainException( 'The value is not in the set of enumerated constants.' );
        }
        $this->value = $value;
    }
}
