<?php
namespace PHP\Collections;

use PHP\Collections\IterableSpec;

/**
 * Defines a set of items that can be iterated over
 */
class Iterable extends \PHP\Object implements IterableSpec
{
    
    /**
     * The indexed set of items
     *
     * @var array
     */
    private $items;
    
    
    /**
     * Creates a new Iterable instance for the items
     *
     * @param array $items The indexed set of items
     */
    public function __construct( array $items )
    {
        $this->items = $items;
    }
    
    
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
