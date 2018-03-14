<?php
namespace PHP\Collections;

use PHP\Object\iObject;

/**
 * Specifications for a set of items that can be iterated over
 */
interface IterableSpec extends iObject
{
    
    /**
     * Iterate through every item, invoking the callback function with the item's
     * index and value
     *
     * To exit, the loop early, return a non-NULL value. This value will be
     * returned by Loop().
     *
     * Additional arguments can be passed to the callback function by adding
     * them to Loop(), after the callback function definition. To make edits to
     * them in the callback function, use the reference identifier `&`.
     *
     * @param callable $function Callback function to execute for each item
     * @param mixed    ...$args  Additional arguments to be passed to the callback function (can be edited by the reference identifier `&` in the callback function)
     * @return mixed   NULL or the value returned by the callback function
     */
    public function Loop( callable $function, &...$args );
}
