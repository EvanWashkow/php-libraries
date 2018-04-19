<?php
namespace PHP\Collections;

/**
 * Specifications for a collection of methods used to iterate over internal values
 */
interface IteratorSpec extends \SeekableIterator, \PHP\PHPObjectSpec
{
    
    /**
     * Iterate through each entry, invoking the callback function with the
     * entry's key and value
     *
     * Outer variables can be passed to the callback function via the `use` clause
     *
     * To exit the loop early, return a non-NULL value. This value will be
     * returned by loop().
     *
     * To take advantage of this function in your own class, you must implement
     * all Iterator methods (http://php.net/manual/en/class.iterator.php), and
     * extend the Iterator class.
     *
     * @param callable $function Callback function to execute for each entry
     * @return mixed NULL or the value returned by the callback function
     */
    public function loop( callable $function );
}
