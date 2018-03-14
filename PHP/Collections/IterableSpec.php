<?php
namespace PHP\Collections;

use PHP\ObjectSpec;

/**
 * Specifications for a set of entries that can be iterated over
 */
interface IterableSpec extends ObjectSpec
{
    
    /**
     * Iterate through every entry, invoking the callback function with the entry's
     * index and value
     *
     * To exit, the loop early, return a non-NULL value. This value will be
     * returned by loop().
     *
     * Additional arguments can be passed to the callback function by adding
     * them to loop(), after the callback function definition. To make edits to
     * them in the callback function, use the reference identifier `&`.
     *
     * @param callable $function Callback function to execute for each entry
     * @param mixed    ...$args  Additional arguments to be passed to the callback function (can be edited by the reference identifier `&` in the callback function)
     * @return mixed   NULL or the value returned by the callback function
     */
    public function loop( callable $function, &...$args );
}
