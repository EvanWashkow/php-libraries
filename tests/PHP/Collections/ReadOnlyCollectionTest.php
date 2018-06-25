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
    
    
    
    
    /***************************************************************************
    *                     ReadOnlyCollection->getValues()
    ***************************************************************************/

    /**
     * Does getValues() return a sequence?
     */
    public function testGetValuesReturnsSequence()
    {
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
            $this->assertInstanceOf(
                "PHP\\Collections\\Sequence",
                $collection->getValues(),
                "Expected Sequence to be returned from ReadOnlyCollection->getValues()"
            );
        }
    }
    
    
    /**
     * Does getValues() return the collection's keys?
     */
    public function testGetValuesReturnsValues()
    {
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
            $values = [];
            $collection->loop(function( $key, $value ) use ( &$values ) {
                $values[] = $value;
            });
            $this->assertEquals(
                $values,
                $collection->getValues()->toArray(),
                "ReadOnlyCollection->getValues() doesn't match the keys inside the collection."
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                    ReadOnlyCollection->isOfKeyType()
    ***************************************************************************/
    
    /**
     * Test if isOfKeyType() rejects null values
     */
    public function testIsOfKeyTypeRejectsNULL()
    {
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
            $this->assertFalse(
                $collection->isOfKeyType( null ),
                "Collection unexpectedly accepted a null key"
            );
        }
    }
    
    
    /**
     * Test if isOfKeyType() allows anything that is not null
     */
    public function testIsOfKeyTypeMixedAllowsAnything()
    {
        foreach ( ReadOnlyCollectionData::GetMixed() as $collection ) {
            $this->assertTrue(
                $collection->isOfKeyType( true ),
                "Untyped collection unexpectedly rejected boolean key"
            );
            $this->assertTrue(
                $collection->isOfKeyType( 1 ),
                "Untyped collection unexpectedly rejected integer key"
            );
            $this->assertTrue(
                $collection->isOfKeyType( 'string' ),
                "Untyped collection unexpectedly rejected string key"
            );
            $this->assertTrue(
                $collection->isOfKeyType( new stdClass() ),
                "Untyped collection unexpectedly rejected object key"
            );
        }
    }
    
    
    /**
     * Test if isOfKeyType() allows its own integer type
     */
    public function testIsOfKeyTypeAllowsMatchingInt()
    {
        $collection = new \PHP\Collections\Dictionary( 'integer' );
        $collection = new \PHP\Collections\ReadOnlyCollection( $collection );
        $this->assertTrue(
            $collection->isOfKeyType( 1 ),
            "Collection with integer keys rejects integer keys"
        );
    }
    
    
    /**
     * Test if isOfKeyType() allows its own string type
     */
    public function testIsOfKeyTypeAllowsMatchingString()
    {
        $collection = new \PHP\Collections\Dictionary( 'string' );
        $collection = new \PHP\Collections\ReadOnlyCollection( $collection );
        $this->assertTrue(
            $collection->isOfKeyType( 'string' ),
            "Collection with string keys rejects string keys"
        );
    }
}
