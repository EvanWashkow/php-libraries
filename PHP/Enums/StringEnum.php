<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;

/**
 * Allows users to define (and select from) a strict set of constant strings
 */
abstract class StringEnum extends Enum
{

    /**
     * Modify Constants to only support strings
     * 
     * @internal Final: it is a strict requirement that all constants in a
     * String Enumeration should be strings.
     * 
     * @param array $constants This class's array of constants
     * @throws \DomainException On non-string constant
     */
    final protected function __constructConstantsDictionary( array $constants )
    {
        $dictionary = new Dictionary( 'string', 'string' );
        foreach ( $constants as $key => $value ) {
            if ( !is_string( $value )) {
                $class = get_class( $this );
                throw new \DomainException( "$class::$key must be a string. All constants defined in a StringEnum must be strings." );
            }
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }


    public function getValue(): string
    {
        return parent::getValue();
    }


    /**
     * Set the current value
     * 
     * @param string $value A value from the set of enumerated constants
     * @return IntegerEnum
     * @throws \InvalidArgumentException If the value is not a string
     * @throws \DomainException If the value is not in the set of enumerated constants
     */
    protected function setValue( $value ): Enum
    {
        if ( !is_string( $value )) {
            throw new \InvalidArgumentException( 'Given value was not a string.' );
        }
        return parent::setValue( $value );
    }
}
