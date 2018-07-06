<?php

require_once( __DIR__ . '/CollectionData.php' );

/**
 * Test all Collection methods to ensure consistent functionality
 */
class CollectionTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                           Collection->clear()
    ***************************************************************************/
    
    /**
     * Test if clearing the collection has a count of zero
     */
    public function testClearHaveNoEntries()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $collection->clear();
            $name = self::getClassName( $collection );
            $this->assertEquals(
                0,
                $collection->count(),
                "Expected {$name}->clear() to remove all elements"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                           Collection->remove()
    ***************************************************************************/
    
    /**
     * Does removing a key from the collection remove the key?
     */
    public function testRemoveHasSmallerCount()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $previous = $collection->count();
            foreach ( $collection as $key => $value ) {
                $collection->remove( $key );
                break;
            }
            $after = $collection->count();
            $this->assertLessThan(
                $previous,
                $after,
                "Dictionary->remove( 'a' ) has the same number of keys as before"
            );
        }
    }
    
    
    /**
     * Does removing a key with a non-existing key fail?
     */
    public function testRemoveThrowsExceptionWithMissingKey()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( 'foobar' );
            } catch (\Exception $e) {
                $isError = true;
            }
            $after = $collection->count();
            
            $this->assertEquals(
                $previous,
                $after,
                "Dictionary->remove() should not be able to remove a key that doesn't exist"
            );
            $this->assertTrue(
                $isError,
                "Dictionary->remove() did not produce an error when invoked with a non-existing key"
            );
        }
    }
    
    
    /**
     * Does removing a key with the wrong key type fail?
     */
    public function testRemoveThrowsExceptionWithWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $key;
            foreach ( $collection as $k => $value ) {
                $key = $value;
                break;
            }
            
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( $key );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $this->assertEquals(
                $previous,
                $after,
                "Dictionary->remove() should not be able to remove a key with the wrong type"
            );
            $this->assertTrue(
                $isError,
                "Dictionary->remove() did not produce an error when invoked with the wrong key type"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                                UTILITIES
    ***************************************************************************/
    
    /**
     * Get the class name of the object
     *
     * @param Iterator $object The Iterator object instance
     * @return string
     */
    protected static function getClassName( Iterator $object ): string
    {
        $name = get_class( $object );
        $name = explode( '\\', $name );
        return array_pop( $name );
    }
}
