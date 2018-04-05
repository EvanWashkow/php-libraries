<?php
namespace PHP\Collections;

use PHP\Collections\IteratorSpec;

/**
 * Defines a collection of methods used to iterate over internal values
 */
abstract class Iterator extends \PHP\PHPObject implements IteratorSpec
{
    
    final public function loop( callable $function, &...$args )
    {
        $this->rewind();
        while ( $this->valid() ) {
            
            // Variables
            $key   = $this->key();
            $value = $this->current();
            
            // Execute callback
            $parameters = array_merge( [ $key, $value ], $args );
            $result     = call_user_func_array( $function, $parameters );
            
            // Exit with non-null value
            if ( null !== $result ) {
                return $result;
            }
            
            // Go to next entry
            $this->next();
        }
        $this->rewind();
    }
}
