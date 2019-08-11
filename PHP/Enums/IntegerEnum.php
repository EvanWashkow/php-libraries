<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;

/**
 * Allows users to define (and select from) a strict set of constant integers
 */
abstract class IntegerEnum extends Enum
{

    /**
     * Modify Constants to only support integers
     * 
     * @internal Final: it is a strict requirement that all constants in a
     * Integer Enumeration should be integers.
     * 
     * @param array $constants This class's array of constants
     * @throws \DomainException On non-integer constant
     */
    final protected function __constructConstantsDictionary( array $constants )
    {
        $dictionary = new Dictionary( 'string', 'integer' );
        foreach ( $constants as $key => $value ) {
            if ( !is_int( $value )) {
                $class = get_class( $this );
                throw new \DomainException( "$class::$key must be a integer. All constants defined in a IntegerEnum must be integers." );
            }
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }


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


    /**
     * Set the current value
     * 
     * @param int $value A value from the set of enumerated constants
     * @return IntegerEnum
     * @throws \InvalidArgumentException If the value is not a integer
     * @throws \DomainException If the value is not in the set of enumerated constants
     */
    protected function setValue( $value ): Enum
    {
        if ( !is_int( $value )) {
            throw new \InvalidArgumentException( 'Given value was not a integer.' );
        }
        return parent::setValue( $value );
    }
}
