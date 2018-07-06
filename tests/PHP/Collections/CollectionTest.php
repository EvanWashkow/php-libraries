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
     * Ensure remove() has smaller count
     */
    public function testRemoveHasSmallerCount()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $previous = $collection->count();
            $collection->loop( function( $key, $value ) use ( $collection ) {
                $collection->remove( $key );
                return 1;
            });
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertLessThan(
                $previous,
                $after,
                "Expected {$name}->remove() to have a smaller count"
            );
        }
    }
    
    
    /**
     * Ensure remove() triggers an error on missing key
     */
    public function testRemoveTriggersErrorForBadKey()
    {
        foreach ( CollectionData::Get() as $collection ) {
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( 'foobar' );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertTrue(
                $isError,
                "Expected {$name}->remove() to produce an error when invoked with a missing key"
            );
        }
    }
    
    
    /**
     * Ensure remove() has same count when given a missing key
     */
    public function testRemoveHasSameCountForBadKey()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( 'foobar' );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $previous,
                $after,
                "Expected {$name}->remove() with a missing key to have same count as before"
            );
        }
    }
    
    
    /**
     * Ensure remove() triggers an error on wrong key type
     */
    public function testRemoveTriggersErrorForWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $value = $collection->loop(function( $key, $value ) {
                return $value;
            });
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( $value );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertTrue(
                $isError,
                "Expected {$name}->remove() to trigger an error when given the wrong key type"
            );
        }
    }
    
    
    /**
     * Ensure remove() has the same count as before when given the wrong key type
     */
    public function testRemoveHasSameCountForWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $value = $collection->loop(function( $key, $value ) {
                return $value;
            });
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( $value );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $previous,
                $after,
                "Expected {$name}->remove() with the wrong key type to have the same count as before"
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
