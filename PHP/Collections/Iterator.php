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
        
        return $returnValue;
    }
    
    
    public function seek( $key )
    {
        // Variables
        $isFound = false;
        
        // Loop through each key, halting when the given key is found
        $this->rewind();
        while ( $this->valid() ) {
            if ( $this->key() === $key ) {
                $isFound = true;
                break;
            }
            $this->next();
        }
        
        // Error on invalid seek
        if ( !$isFound ) {
            $this->throwSeekError( $key );
        }
    }
    
    
    /**
     * Throws an error when the seek position is not found
     *
     * @param mixed $key The key not found
     */
    protected function throwSeekError( $key )
    {
        throw new \OutOfBoundsException( 'Invalid seek position' );
    }
}
