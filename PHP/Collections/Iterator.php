<?php
namespace PHP\Collections;

/**
 * Defines a collection of methods used to iterate over internal values
 *
 * NOTE: Prefer the loop() function to foreach(). PHP's Iterator interface does
 * not work properly in nested foreach() loops. This is because PHP passes
 * objects by reference, not by value. Therefore, when the inner loop executes,
 * it is not operating on its own copy of the Iterator object, but on the same
 * copy as the outer loop. This causes the inside loop to reset and increment
 * the outer loop's cursor, since they are one and the same. When the inner
 * loop finishes executing, the outer loop also exits since its cursor is now
 * at an invalid position. The loop() function fixes this issue entirely by
 * restoring the outer loop's cursor position after exiting the inner loop.
 */
abstract class Iterator extends \PHP\PHPObject implements IteratorSpec
{
    
    final public function loop( callable $function, &...$args )
    {
        // Variables
        $returnValue = null;
        
        // Stash outer loop position (if there is one)
        $outerLoopKey = null;
        if ( $this->valid() ) {
            $outerLoopKey = $this->key();
        }
        
        // Loop through each value, until the return value is not null
        $this->rewind();
        while ( $this->valid() ) {
            
            // Variables
            $key   = $this->key();
            $value = $this->current();
            
            // Execute callback function
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
        
        // Restore outer loop position (if there is one)
        if ( null !== $outerLoopKey ) {
            try {
                $this->seek( $outerLoopKey );
            } catch ( \Exception $e ) {
                trigger_error( 'Failed to restore outer loop position from inside ' . get_class( $this ) . '->' . __FUNCTION__ . '(). You may experience unexpected behavior.' );
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
