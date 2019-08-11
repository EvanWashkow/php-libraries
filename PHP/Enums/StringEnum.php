<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;

/**
 * Allows users to define (and select from) a strict set of constant strings
 */
abstract class StringEnum extends Enum
{


    /***************************************************************************
    *                              CONSTRUCTOR METHODS
    ***************************************************************************/


    /**
     * Create a new Enumeration string instance
     * 
     * @param string $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     */
    public function __construct( string $value )
    {
        parent::__construct( $value );
    }


    /**
     * Modify Constants to only support strings
     * 
     * @internal Final: it is a strict requirement that all constants in a
     * String Enumeration should be strings.
     * 
     * @param Dictionary $constants This class's constants
     * @throws \DomainException On non-string constant
     */
    final protected function modifyConstantsDictionary( Dictionary $constants ): Dictionary
    {
        $dictionary = new Dictionary( 'string', 'string' );
        foreach ( $constants->toArray() as $key => $value ) {
            if ( !is_string( $value )) {
                $class = get_class( $this );
                throw new \DomainException( "$class::$key is not a string. All StringEnum Constants must be a string." );
            }
            $dictionary->set( $key, $value );
        }
        return $dictionary;
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
    final public function getValue(): string
    {
        return parent::getValue();
    }
}
