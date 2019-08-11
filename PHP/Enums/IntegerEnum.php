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
     * @internal Not final. Other enums may want to enforce a subset of integer
     * values.
     * 
     * @param Dictionary $constants This class's constants
     * @return Dictionary
     * @throws \DomainException On non-integer constant
     */
    protected function filterConstants( Dictionary $constants ): Dictionary
    {
        $dictionary = new Dictionary( 'string', 'integer' );
        foreach ( $constants->toArray() as $key => $value ) {
            if ( !is_int( $value )) {
                $class = get_class( $this );
                throw new \DomainException( "$class::$key is not an integer. All IntegerEnum Constants must be an integer." );
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
     * @internal Final: the returned value cannot be modified. It is the direct
     * result of other underlying methods.
     */
    final public function getValue(): int
    {
        return parent::getValue();
    }
}
