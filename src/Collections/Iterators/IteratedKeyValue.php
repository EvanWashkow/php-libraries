<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iterators;

use PHP\Collections\KeyValuePair;

/**
 * @deprecated Only here for backwards compatibility. 04-2020.
 */
class IteratedKeyValue extends KeyValuePair
{


    /**
     * Forward any calls on to the value
     */
    public function __call( string $name, array $arguments )
    {
        trigger_error(
            'foreach( Dictionary as $item ) behavior has changed. Call $item->getValue() before calling the value\'s method.',
            E_USER_DEPRECATED
        );
        return call_user_func( [ $this->getValue(), $name ], ...$arguments );
    }


    /**
     * Forward any property access on to the value
     */
    public function __get( string $name )
    {
        trigger_error(
            'foreach( Dictionary as $item ) behavior has changed. Call $item->getValue() before accessing the value\'s property.',
            E_USER_DEPRECATED
        );
        return $this->getValue()->$name;
    }
}