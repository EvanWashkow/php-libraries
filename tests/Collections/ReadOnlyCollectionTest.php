<?php
namespace PHP\Tests;

use PHP\Collections\Dictionary;
use PHP\Collections\ReadOnlyCollection;

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/ReadOnlyCollectionData.php' );

/**
 * Test all ReadOnlyCollection methods to ensure consistent functionality
 *
 * NOTE: ReadOnlyCollections tests also tests the underlying collection
 */
class ReadOnlyCollectionTest extends CollectionsTestCase
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
        foreach ( ReadOnlyCollectionData::Get() as $collection ) {
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
    *                            ReadOnlyCollection->hasValue()
    ***************************************************************************/


    /**
     * Ensure ReadOnlyCollection->hasValue() returns true for the value
     **/
    public function testHasValueReturnsTrueForValue()
    {
        $dictionary = new Dictionary( 'integer', 'integer' );
        $dictionary->set( 0, 1 );
        $roc = new ReadOnlyCollection( $dictionary );
        $this->assertTrue(
            $roc->hasValue( 1 ),
            'ReadOnlyCollection->hasValue() should return true for the value'
        );
    }


    /**
     * Ensure ReadOnlyCollection->hasValue() returns false for wrong value
     **/
    public function testHasValueReturnsFalseForWrongValue()
    {
        $dictionary = new Dictionary( 'integer', 'integer' );
        $dictionary->set( 0, 1 );
        $roc = new ReadOnlyCollection( $dictionary );
        $this->assertFalse(
            $roc->hasValue( 2 ),
            'ReadOnlyCollection->hasValue() should return false for wrong value'
        );
    }


    /**
     * Ensure ReadOnlyCollection->hasValue() returns false for wrong value type
     **/
    public function testHasValueReturnsFalseForWrongValueType()
    {
        $dictionary = new Dictionary( 'integer', 'integer' );
        $dictionary->set( 0, 1 );
        $roc = new ReadOnlyCollection( $dictionary );
        $this->assertFalse(
            $roc->hasValue( '1' ),
            'ReadOnlyCollection->hasValue() should return false for wrong value type'
        );
    }
    
    
    
    
    /***************************************************************************
    *                    ReadOnlyCollection->isOfKeyType()
    ***************************************************************************/


    /**
     * Ensure isOfKeyType throws an error
     **/
    public function testIsOfKeyTypeThrowsDeprecatedError()
    {
        $isError = false;
        try {
            $collection = new \PHP\Collections\Sequence();
            $collection = new \PHP\Collections\ReadOnlySequence( $collection );
            $collection->isOfKeyType( 'int' );
        }
        catch ( \Exception $e ) {
            $isError = true;
        }
        $this->assertTrue(
            $isError,
            'Ensure ReadOnlyCollection->isOfKeyType() throws a deprecation error'
        );
    }
    
    
    
    
    /***************************************************************************
    *                               isOfValueType()
    ***************************************************************************/


    /**
     * Ensure isOfValueType() throws an error
     **/
    public function testIsOfValueTypeThrowsDeprecatedError()
    {
        $isError = false;
        try {
            $collection = new \PHP\Collections\Sequence();
            $collection = new \PHP\Collections\ReadOnlySequence( $collection );
            $collection->isOfValueType( 'int' );
        }
        catch ( \Exception $e ) {
            $isError = true;
        }
        $this->assertTrue(
            $isError,
            'Ensure Collection->isOfValueType() throws a deprecation error'
        );
    }
}
