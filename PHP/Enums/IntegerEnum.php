<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;

/**
 * Allows users to define (and select from) a strict set of constant integers
 */
abstract class IntegerEnum extends Enum
{


    /***************************************************************************
    *                              CONSTRUCTOR METHODS
    ***************************************************************************/


    /**
     * Create a new Enumeration integer instance
     * 
     * @param int $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     */
    public function __construct( int $value )
    {
        parent::__construct( $value );
    }


    /**
     * Modify Constants to only support integers
     * 
     * @internal Final: it is a strict requirement that all constants in a
     * Integer Enumeration should be integers.
     * 
     * @param Dictionary $constants This class's constants
     * @return Dictionary
     * @throws \DomainException On non-integer constant
     */
    final protected function modifyConstantsDictionary( Dictionary $constants ): Dictionary
    {
        $dictionary = new Dictionary( 'string', 'integer' );
        foreach ( $constants->toArray() as $key => $value ) {
            if ( !is_int( $value )) {
                $class = get_class( $this );
                throw new \DomainException( "$class::$key must be a integer. All constants defined in a IntegerEnum must be integers." );
            }
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }


    /**
     * @see parent::maybeGetValueException()
     */
    protected function maybeGetValueException( $value ): ?\Throwable
    {
        $exception = null;
        if ( is_int( $value )) {
            $exception = parent::maybeGetValueException( $value );
        }
        else {
            $exception = new \InvalidArgumentException(
                'Given value was not a integer.'
            );
        }
        return $exception;
    }




    /***************************************************************************
    *                                    MAIN
    ***************************************************************************/


    /**
     * @see parent::getValue()
     * 
     * @internal Final: the returned value cannot be modified. It directly
     * correlates with other underlying methods.
     */
    final public function getValue(): int
    {
        return parent::getValue();
    }
}
