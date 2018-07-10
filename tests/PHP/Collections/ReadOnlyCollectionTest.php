<?php

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/ReadOnlyCollectionData.php' );

/**
 * Test all ReadOnlyCollection methods to ensure consistent functionality
 *
 * NOTE: ReadOnlyCollections tests also tests the underlying collection
 */
class ReadOnlyCollectionTest extends \PHP\Tests\Collections\CollectionsTestCase
{
    
    /***************************************************************************
    *                         ReadOnlyCollection->clone()
    ***************************************************************************/
    
    /**
     * Ensure clone() returns the same type
     */
    public function testCloneReturnsSameType()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $this->assertEquals(
                get_class( $collection ),
                get_class( $collection->clone() ),
                "Expected {$name}->clone() to return the same type"
            );
        }
    }
    
    
    /**
     * Ensure clone() has same keys
     */
    public function testCloneReturnsSameKeys()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $collection->getKeys()->toArray(),
                $collection->clone()->getKeys()->toArray(),
                "Expected {$name}->clone() to return the same keys"
            );
        }
    }
    
    
    /**
     * Ensure clone() has same values
     */
    public function testCloneReturnsSameValues()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $collection->getValues()->toArray(),
                $collection->clone()->getValues()->toArray(),
                "Expected {$name}->clone() to return the same values"
            );
        }
    }
    
    
    /**
     * Ensure clone() has same count
     */
    public function testCloneHasSameCount()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $collection->count(),
                $collection->clone()->count(),
                "Expected {$name}->clone() to have same count"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                       ReadOnlyCollection->count()
    ***************************************************************************/
    
    /**
     * Ensure that count() returns a positive value for non-empty collections
     */
    public function testCountIsPositiveForNonEmpty()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $this->assertGreaterThanOrEqual(
                1,
                $collection->count(),
                "Expected {$name}->count() to return an positive value for non-empty collections"
            );
        }
    }
    
    
    /**
     * Ensure that count() returns zero for empty collections
     */
    public function testCountIsZeroForEmpty()
    {
        foreach ( ReadOnlyCollectionData::GetEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $this->assertEquals(
                0,
                $collection->count(),
                "Expected {$name}->count() to return zero for empty collections"
            );
        }
    }
    
    
    /**
     * Ensure that count() returns an integer value
     */
    public function testCountReturnsInt()
    {
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
            $name = self::getClassName( $collection );
            $this->assertEquals(
                'integer',
                gettype( $collection->count() ),
                "Expected {$name}->count() to return an integer value"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                         ReadOnlyCollection->get()
    ***************************************************************************/
    
    /**
     * Ensure that get() retrieves the value at that key
     */
    public function testGetReturnsValue()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $collection->loop(function( $key, $value ) use ( $collection, $name ) {
                $this->assertTrue(
                    $value === $collection->get( $key ),
                    "Expected {$name}->get() to return the value stored at that key"
                );
            });
        }
    }
    
    
    /**
     * Ensure that get() returns value of that value type
     */
    public function testGetReturnsValueOfValueType()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $collection->loop(function( $key, $value ) use ( $collection, $name ) {
                $this->assertTrue(
                    $collection->isOfValueType( $collection->get( $key ) ),
                    "Expected {$name}->get() to return the value of the same type"
                );
            });
        }
    }
    
    
    /**
     * Ensure that get() throws InvalidArgumentException on missing key
     */
    public function testGetThrowsInvalidArgumentExceptionOnMissingKey()
    {
        $badKey = '5000foobarsinarow';
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $name = self::getClassName( $collection );
            $collection->loop(function( $key, $value ) use ( $collection, $badKey, $name ) {
                $exception = null;
                try {
                    $collection->get( $badKey );
                } catch (\Exception $e) {
                    $exception = $e;
                }
                $this->assertTrue(
                    'InvalidArgumentException' === get_class( $exception ),
                    "Expected {$name}->get() to throw an InvalidArgumentException on a bad key"
                );
            });
        }
    }
    
    
    /**
     * Ensure that get() throws InvalidArgumentException on null key
     */
    public function testGetThrowsInvalidArgumentExceptionOnNullKey()
    {
        $badKey = [ new stdClass() ];
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
            $name = self::getClassName( $collection );
            $collection->loop(function( $key, $value ) use ( $collection, $badKey, $name ) {
                $exception = null;
                try {
                    $collection->get( null );
                } catch (\Exception $e) {
                    $exception = $e;
                }
                $this->assertTrue(
                    'InvalidArgumentException' === get_class( $exception ),
                    "Expected {$name}->get() to throw an InvalidArgumentException on wrong key type"
                );
            });
        }
    }
    
    
    /**
     * Ensure that get() throws InvalidArgumentException on wrong key type
     */
    public function testGetThrowsInvalidArgumentExceptionOnWrongKeyType()
    {
        $badKey = [ new stdClass() ];
        foreach ( ReadOnlyCollectionData::GetTyped() as $collection ) {
            $name = self::getClassName( $collection );
            $collection->loop(function( $key, $value ) use ( $collection, $badKey, $name ) {
                $exception = null;
                try {
                    $collection->get( $value );
                } catch (\Exception $e) {
                    $exception = $e;
                }
                $this->assertTrue(
                    'InvalidArgumentException' === get_class( $exception ),
                    "Expected {$name}->get() to throw an InvalidArgumentException on wrong key type"
                );
            });
        }
    }
    
    
    
    
    /***************************************************************************
    *                       ReadOnlyCollection->getKeys()
    ***************************************************************************/

    /**
     * Does getKeys() return a sequence?
     */
    public function testGetKeysReturnsSequence()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
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
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
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
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
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
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
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
    *                        ReadOnlyDictionary->hasKey()
    ***************************************************************************/
    
    /**
     * Ensure hasKey() return a boolean value
     */
    public function testHasKeyReturnsBoolean()
    {
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
            $collection->loop(function( $key, $value ) use ( $collection ) {
                $name = self::getClassName( $collection );
                $this->assertEquals(
                    'boolean',
                    gettype( $collection->hasKey( $key ) ),
                    "Expected {$name}->hasKey() to return a boolean value"
                );
                $this->assertEquals(
                    'boolean',
                    gettype( $collection->hasKey( $value ) ),
                    "Expected {$name}->hasKey() to return a boolean value"
                );
            });
        }
    }
    
    
    /**
     * Does hasKey() return false for missing keys?
     */
    public function testHasKeyReturnsFalseForMissingKeys()
    {
        foreach ( ReadOnlyCollectionData::GetTyped() as $collection ) {
            $collection->loop(function( $key, $value ) use ( $collection ) {
                $name = self::getClassName( $collection );
                $this->assertFalse(
                    $collection->hasKey( $value ),
                    "Expected {$name}->hasKey() to return false for missing key"
                );
            });
        }
    }
    
    
    /**
     * Does hasKey() return true for existing keys?
     */
    public function testHasKeyReturnsTrueForExistingKeys()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $collection->loop(function( $key, $value ) use ( $collection ) {
                $name = self::getClassName( $collection );
                $this->assertTrue(
                    $collection->hasKey( $key ),
                    "Expected {$name}->hasKey() to return true for existing key"
                );
            });
        }
    }
    
    
    
    
    /***************************************************************************
    *                    ReadOnlyCollection->isOfKeyType()
    ***************************************************************************/
    
    /**
     * Test if isOfKeyType() rejects null values
     */
    public function testIsOfKeyTypeReturnsFalseForNull()
    {
        foreach ( ReadOnlyCollectionData::GetNonEmpty() as $collection ) {
            $this->assertFalse(
                $collection->isOfKeyType( null ),
                "Collection unexpectedly accepted a null key"
            );
        }
    }
    
    
    /**
     * Test if isOfKeyType() allows anything that is not null
     */
    public function testIsOfKeyTypeReturnsTrueForAnyKeyTypeInMixed()
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
    public function testIsOfKeyTypeReturnsTrueForMatchingKeyType()
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
    public function testIsOfKeyTypeReturnsFalseForWrongKeyType()
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
    public function testIsOfValueTypeReturnsTrueForAnyValueTypeInMixed()
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
    public function testIsOfValueTypeReturnnsTrueForMatchingValueType()
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
    public function testIsOfValueTypeReturnsFalseForWrongValueType()
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
