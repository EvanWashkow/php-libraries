<?php

require_once( __DIR__ . '/ReadOnlyCollectionData.php' );

/**
 * Test ReadOnlyCollection methods
 */
class ReadOnlyCollectionTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                       ReadOnlyCollection->getKeys()
    ***************************************************************************/

    /**
     * Does getKeys() return a sequence?
     */
    public function testGetKeysReturnsSequence()
    {
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
            $this->assertInstanceOf(
                "PHP\\Collections\\Sequence",
                $collection->getKeys(),
                "Expected Sequence to be returned from ReadOnlyCollection->getKeys()"
            );
        }
    }
    
    
    /**
     * Does getKeys() return the collection's keys?
     */
    public function testGetKeysReturnsKeys()
    {
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
            $keys = [];
            $collection->loop(function( $key, $value ) use ( &$keys ) {
                $keys[] = $key;
            });
            $this->assertEquals(
                $keys,
                $collection->getKeys()->toArray(),
                "ReadOnlyCollection->getKeys() doesn't match the keys inside the collection."
            );
        }
    }
}
