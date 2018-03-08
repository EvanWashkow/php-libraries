<?php
namespace PHP\Types;

/**
 * Defines a set of items, with arbitrary indexes, that can be iterated over
 */
class Iterable
{
    
    /**
     * The indexed set of items
     *
     * @var array
     */
    protected $items;
    
    
    /**
     * Creates a new Iterable instance for the items
     *
     * @param array $items The indexed set of items
     */
    public function __construct( array $items )
    {
        $this->items = $items;
    }
    
    
    /**
     * Convert this iterable to a PHP array
     *
     * @return array
     */
    public function ConvertToArray(): array
    {
        return $this->items;
    }
    
    
    /**
     * Retrieve the number of items
     *
     * @return int
     */
    public function Count(): int
    {
        return count( $this->items );
    }
    
    
    /**
     * For each item in the list, invoke the callback function with its index
     * and value
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
    public function Loop( callable $function, &...$args )
    {
        foreach ( $this->items as $index => $value ) {
            
            // Add index and value the callback function parameters
            $parameters = array_merge(
                [
                    $index,
                    $value
                ],
                $args
            );
            
            // Execute the callback function, exiting when a non-null value is returned
            $result = call_user_func_array( $function, $parameters );
            if ( null !== $result ) {
                return $result;
            }
        }
    }
}
