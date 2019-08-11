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


    /**
     * @see parent::maybeGetValueException()
     */
    protected function maybeGetValueException( $value ): ?\Throwable
    {
        $exception = null;
        if ( is_string( $value )) {
            $exception = parent::maybeGetValueException( $value );
        }
        else {
            $exception = new \InvalidArgumentException(
                'Given value was not a string.'
            );
        }
        return $exception;
    }
}
