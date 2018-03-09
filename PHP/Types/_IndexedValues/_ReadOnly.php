<?php
namespace PHP\Types\_IndexedValues;

/**
 * Defines structure for a set of indexed, read-only values
 */
abstract class _ReadOnly extends \PHP\Types\Object
{
    
    /**
     * Convert to a native PHP array
     *
     * @return array
     */
    abstract public function ConvertToArray(): array;
    
    /**
     * Count all items, returning the result
     *
     * @return int
     */
    abstract public function Count(): int;
    
    /**
     * Retrieve the value stored at the specified index
     *
     * @param mixed $index The index to retrieve the value from
     * @return mixed The value if the index exists. NULL otherwise.
     */
    abstract public function Get( $index );
    
    /**
     * Determine if the index exists
     *
     * @param mixed $index The index to check
     * @return bool
     */
    abstract public function HasIndex( $index ): bool;
    
    /**
     * Iterate through every item, invoking the callback function with the
     * item's index and value
     *
     * To exit the loop early, return a non-NULL value. This value will also be
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
    abstract public function Loop( callable $function, &...$args );
}
