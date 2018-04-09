<?php
namespace PHP\Collections;

/**
 * Defines a collection of methods used to iterate over internal values
 */
abstract class Iterator extends \PHP\PHPObject implements IteratorSpec
{
    
    final public function loop( callable $function, &...$args )
    {
        // Variables
        $returnValue = null;
        
        // Loop through each value, until the return value is not null
        $this->rewind();
        while ( $this->valid() ) {
            
            // Variables
            $key   = $this->key();
            $value = $this->current();
            
            // Execute callback
            $parameters  = array_merge( [ $key, $value ], $args );
            $returnValue = call_user_func_array( $function, $parameters );
            
            // Go to next entry or stop loop
            if ( null === $returnValue ) {
                $this->next();
            }
            else {
                break;
            }
            
        }
        $this->rewind();
        
        return $returnValue;
    }
}
