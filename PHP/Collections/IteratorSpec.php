<?php
namespace PHP\Collections;

use PHP\PHPObjectSpec;

/**
 * Specifications for a collection of methods used to iterate over internal values
 */
interface IteratorSpec extends \Iterator, PHPObjectSpec
{
    
    /**
     * Iterate through each entry, invoking the callback function with the entry's
     * key and value
     *
     * To exit the loop early, return a non-NULL value. This value will be
     * returned by loop().
     *
     * Additional arguments can be passed to the callback function by adding
     * them to loop(), after the callback function definition. To make edits to
     * them in the callback function, use the reference identifier `&`.
     *
     * To take advantage of this function in your own class, you must implement
     * all Iterator methods (http://php.net/manual/en/class.iterator.php), and
     * extend the Iterator class.
     *
     * @param callable $function Callback function to execute for each entry
     * @param mixed    ...$args  Additional arguments to be passed to the callback function (can be edited by the reference identifier `&` in the callback function)
     * @return mixed   NULL or the value returned by the callback function
     */
    public function loop( callable $function, &...$args );
}
