<?php

declare(strict_types=1);

namespace PHP\Collections\Iterators;

use PHP\Collections\KeyValuePair;

/**
 * Provides backwards compatibility with old foreach( Dictionary as $key => $value ) behavior.
 *
 * Now, rather than accessing the $value's properties and methods directly, the programmer must use a KeyValuePair (this
 * class). Old implementations are not yet compatible with this behavior, and are still accessing the value's properties
 * and methods directly. This class forwards such calls to getValue().
 *
 * @deprecated Only here for backwards compatibility. 04-2020.
 */
class DeprecatedKeyValuePair extends KeyValuePair
{
    /**
     * Forward any calls on to the value.
     */
    public function __call(string $name, array $arguments)
    {
        static $isFirstCall = true;
        if ($isFirstCall) {
            trigger_error(
                'foreach( Dictionary as $item ) behavior has changed. Call $item->getValue() before calling the value\'s method.',
                E_USER_DEPRECATED
            );
            $isFirstCall = false;
        }

        return call_user_func([$this->getValue(), $name], ...$arguments);
    }

    /**
     * Forward any property access on to the value.
     */
    public function __get(string $name)
    {
        static $isFirstGet = true;
        if ($isFirstGet) {
            trigger_error(
                'foreach( Dictionary as $item ) behavior has changed. Call $item->getValue() before accessing the value\'s property.',
                E_USER_DEPRECATED
            );
            $isFirstGet = false;
        }

        return $this->getValue()->{$name};
    }
}
