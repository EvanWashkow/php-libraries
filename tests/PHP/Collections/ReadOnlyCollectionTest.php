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
    public function testIsOfKeyTypeAllowsAnyKeyInMixed()
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
     * Test if isOfKeyType() allows its own key type
     */
    public function testIsOfKeyTypeAllowsMatchingKeyType()
    {
        foreach ( ReadOnlyCollectionData::GetTyped() as $collection ) {
            foreach ( $collection as $key => $value ) {
                $this->assertTrue(
                    $collection->isOfKeyType( $key ),
                    "Collection with defined key types rejects its own keys"
                );
                break;
            }
        }
    }
    
    
    /**
     * Test if isOfKeyType() rejects other types
     */
    public function testIsOfKeyTypeRejectsMixMatchedKeyType()
    {
        foreach ( ReadOnlyCollectionData::GetTyped() as $collection ) {
            foreach ( $collection as $key => $value ) {
                $this->assertFalse(
                    $collection->isOfKeyType( $value ),
                    "Collection with defined key types rejects its own keys"
                );
                break;
            }
        }
    }
    
    
    
    
    /***************************************************************************
    *                    ReadOnlyCollection->isOfValueType()
    ***************************************************************************/
    
    
    /**
     * Test if isOfValueType() allows anything
     */
    public function testIsOfValueTypeAllowsAnyValueInMixed()
    {
        foreach ( ReadOnlyCollectionData::GetMixed() as $collection ) {
            $this->assertTrue(
                $collection->isOfValueType( null ),
                "Untyped collection unexpectedly rejected null value"
            );
            $this->assertTrue(
                $collection->isOfValueType( true ),
                "Untyped collection unexpectedly rejected boolean value"
            );
            $this->assertTrue(
                $collection->isOfValueType( 1 ),
                "Untyped collection unexpectedly rejected integer value"
            );
            $this->assertTrue(
                $collection->isOfValueType( 'string' ),
                "Untyped collection unexpectedly rejected string value"
            );
            $this->assertTrue(
                $collection->isOfValueType( new stdClass() ),
                "Untyped collection unexpectedly rejected object value"
            );
        }
    }
    
    
    /**
     * Test if isOfValueType() allows its own value type
     */
    public function testIsOfValueTypeAllowsMatchingValueType()
    {
        foreach ( ReadOnlyCollectionData::GetTyped() as $collection ) {
            foreach ( $collection as $key => $value ) {
                $this->assertTrue(
                    $collection->isOfValueType( $value ),
                    "Collection with defined value types rejects its own values"
                );
                break;
            }
        }
    }
    
    
    /**
     * Test if isOfValueType() rejects other types
     */
    public function testIsOfValueTypeRejectsMixMatchedValueType()
    {
        foreach ( ReadOnlyCollectionData::GetTyped() as $collection ) {
            foreach ( $collection as $key => $value ) {
                $this->assertFalse(
                    $collection->isOfValueType( $key ),
                    "Collection with defined value types rejects its own values"
                );
                break;
            }
        }
    }
}
