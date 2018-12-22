<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\Collections\Collection;
use PHP\Collections\Dictionary;
use PHP\Collections\Sequence;


require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/CollectionData.php' );

/**
 * Test all Collection methods to ensure consistent functionality
 */
class CollectionTest extends CollectionsTestCase
{


    /***************************************************************************
    *                           Collection->__construct()
    ***************************************************************************/


    /**
     * Ensure the constructor throws an error for null key types
     * 
     * @expectedException \InvalidArgumentException
     **/
    public function testConstructorThrowsErrorForNullKey()
    {
        new Dictionary( 'null' );
    }


    /**
     * Ensure the constructor throws an error for unknown key types
     * 
     * @expectedException \InvalidArgumentException
     **/
    public function testConstructorThrowsErrorForUnknownKey()
    {
        new Dictionary( 'foobar' );
    }


    /**
     * Ensure the constructor throws an error for null value types
     * 
     * @expectedException \InvalidArgumentException
     **/
    public function testConstructorThrowsErrorForNullValue()
    {
        new Dictionary( '', 'null' );
    }


    /**
     * Ensure the constructor throws an error for unknown value types
     * 
     * @expectedException \InvalidArgumentException
     **/
    public function testConstructorThrowsErrorForUnknownValue()
    {
        new Dictionary( '', 'foobar' );
    }




    /***************************************************************************
    *                           Collection->clear()
    ***************************************************************************/
    
    /**
     * Ensure clear() has no entries
     */
    public function testClearHasNoEntries()
    {
        foreach ( CollectionData::Get() as $collection ) {
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
    *                           Collection->clone()
    ***************************************************************************/


    /**
     * Ensure shallow clone $this rewinds the collection
     * 
     * @dataProvider getCloneRewindsData
     * 
     * @param Collection $collection       The collection to clone
     * @param mixed      $expectedFirstKey The first key of the collection
     */
    public function testShallowCloneRewinds( Collection $collection, $expectedFirstKey )
    {
        $clone = clone $collection;
        $this->assertEquals(
            $expectedFirstKey,
            $clone->key(),
            'The cloned collection did not rewind to the beginning of the iterator'
        );
    }


    /**
     * Ensure deep Collection->clone() rewinds the collection
     * 
     * @dataProvider getCloneRewindsData
     * 
     * @param Collection $collection       The collection to clone
     * @param mixed      $expectedFirstKey The first key of the collection
     */
    public function testDeepCloneRewinds( Collection $collection, $expectedFirstKey )
    {
        $this->assertEquals(
            $expectedFirstKey,
            $collection->clone()->key(),
            'Collection->clone() did not rewind to the beginning of the iterator'
        );
    }


    /**
     * Retrieve test data for testing that clone rewinds the collection
     * 
     * @return array
     */
    public function getCloneRewindsData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( 'foo', 'bar' );
        $dictionary->set( 'biz', 'baz' );
        $dictionary->next();

        $sequence = new Sequence();
        $sequence->add( 'foo' );
        $sequence->add( 'bar' );
        $sequence->add( 'biz' );
        $sequence->add( 'baz' );
        $sequence->next();
        $sequence->next();

        return [
            'Empty Dictionary' => [
                new Dictionary(), NULL
            ],
            'Non-empty Dictionary' => [
                $dictionary, 'foo'
            ],
            'Empty Sequence' => [
                new Sequence(), NULL
            ],
            'Non-empty Sequence' => [
                $sequence, 0
            ]
        ];
    }




    /***************************************************************************
    *                            Collection->count()
    ***************************************************************************/

    /**
     * Ensure Collection->count() returns the correct count
     * 
     * @dataProvider getCountData
     * 
     * @param Collection $collection The collection to test
     * @param int        $expected   The expected count
     **/
    public function testCount( Collection $collection, int $expected )
    {
        $this->assertTrue(
            $expected === $collection->count(),
            'Collection->count() was incorrect'
        );
    }


    /**
     * Retrieve test data for count tests
     * 
     * @return array
     */
    public function getCountData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( 0, 0 );
        $dictionary->set( 1, 1 );
        $dictionary->set( 2, 2 );

        $sequence = new Sequence();
        $sequence->add( 0 );
        $sequence->add( 1 );
        $sequence->add( 2 );

        return [
            [ ( new Dictionary() ), 0 ],
            [ $dictionary,          3 ],
            [ ( new Sequence() ),   0 ],
            [ $sequence,            3 ]

        ];
    }




    /***************************************************************************
    *                              Collection->get()
    ***************************************************************************/


    /**
     * Ensure Collection->get() returns the correct value
     * 
     * @dataProvider getGetData
     * 
     * @param Collection $collection The collection to test
     * @param mixed      $key        The key to access
     * @param mixed      $expected   The expected value
     **/
    public function testGet( Collection $collection, $key, $expected )
    {
        $this->assertTrue(
            $expected === $collection->get( $key ),
            'Collection->get() was incorrect'
        );
    }


    /**
     * Retrieve test data for get tests
     * 
     * @return array
     */
    public function getGetData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( 0, 'foo' );
        $dictionary->set( 1, true );
        $dictionary->set( 2, 'bar' );

        $sequence = new Sequence();
        $sequence->add( 'foo' );
        $sequence->add( true );
        $sequence->add( 'bar' );

        return [
            [ $dictionary, 1, true ],
            [ $sequence,   1, true ]
        ];
    }


    /**
     * Ensure Collection->get() throws an exception on missing key
     * 
     * @dataProvider      getGetExceptionData
     * @expectedException InvalidArgumentException
     * 
     * @param Collection $collection The collection to test
     * @param mixed      $key        The key to access
     **/
    public function testGetException( Collection $collection, $key )
    {
        $collection->get( $key );
    }


    /**
     * Retrieve test data for get tests
     * 
     * @return array
     */
    public function getGetExceptionData(): array
    {
        // Wrong key type
        $dictionary = new Dictionary( 'int', 'string' );
        $dictionary->set( 0, '0' );
        $sequence = new Sequence( 'string' );
        $sequence->add( '0' );

        return [

            // null cannot be a key
            [ new Dictionary(), null ],
            [ new Sequence(),   null ],
            

            // Missing keys
            [ new Dictionary(), 0 ],
            [ new Sequence(),   0 ],

            // Wrong key type
            [ $dictionary, '0' ],
            [ $sequence,   '0' ]
        ];
    }




    /***************************************************************************
    *                            Collection->getKeyOf()
    ***************************************************************************/


    /**
     * Test getKeyOf() return values
     * 
     * @dataProvider getGetKeyOfData
     *
     * @param Collection $sequence The collection
     * @param mixed      $value    The value to get the key of
     * @param mixed      $expected The expected key
     **/
    public function testGetKeyOf( Collection $collection, $value, $expected )
    {
        $this->assertEquals( $collection->getKeyOf( $value ), $expected );
    }


    /**
     * Retrieve test data for the getKeyOf() test
     *
     * @return array
     **/
    public function getGetKeyOfData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( '0', 0 );
        $dictionary->set( '1', 1 );

        $sequence = new Sequence();
        $sequence->add( 0 );
        $sequence->add( 1 );

        return [

            // Dictionary
            'Empty Dictionary; unknown value' => [
                new Dictionary(), 0, NULL
            ],
            'Dictionary; unknown value' => [
                $dictionary, 2, NULL
            ],
            'Dictionary; value 0' => [
                $dictionary, 0, '0'
            ],
            'Dictionary; value 1' => [
                $dictionary, 1, '1'
            ],

            // Sequence
            'Empty Sequence; unknown value' => [
                new Sequence(), 0, NULL
            ],
            'Sequence; unknown value' => [
                $sequence, 2, NULL
            ],
            'Sequence; value 0' => [
                $sequence, 0, 0
            ],
            'Sequence; value 1' => [
                $sequence, 1, 1
            ]
        ];
    }




    /***************************************************************************
    *                            Collection->getKeys()
    ***************************************************************************/


    /**
     * Ensure getKeys() returns a sequence
     * 
     * @dataProvider getCollectionData
     * 
     * @param Collection $collection The collection
     */
    public function testGetKeysReturnType( Collection $collection )
    {
        $this->assertInstanceOf(
            Sequence::class,
            $collection->getKeys(),
            'Collection->getKeys() should always return a Sequence'
        );
    }


    /**
     * Ensure getKeys() returns the correct results
     * 
     * @dataProvider getGetKeysData
     * 
     * @param Collection $collection The collection
     */
    public function testGetKeys( Collection $collection, array $expected )
    {
        $this->assertTrue(
            $expected === $collection->getKeys()->toArray(),
            'Collection->getKeys() didn\'t return the correct results'
        );
    }
    
    
    /**
     * Retrieve test data for getKeys() test
     * 
     * @todo Test Dictionary->getKeys() does not return strings for integer keys
     */
    public function getGetKeysData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( 'foo',   'bar' );
        $dictionary->set( 'false', true );
        $dictionary->set( '1',     0 );

        $sequence = new Sequence();
        $sequence->add( 2 );
        $sequence->add( '1' );
        $sequence->add( false );

        return [
            [ $dictionary, [ 'foo', 'false', '1' ] ],
            [ $sequence,   [ 0, 1, 2 ] ]
        ];
    }




    /***************************************************************************
    *                          Collection->getKeyType()
    ***************************************************************************/


    /**
     * Ensure getKeyType() has the same name
     */
    public function testGetKeyTypeHasSameName()
    {
        $this->assertEquals(
            'int',
            ( new Dictionary( 'integer' ) )->getKeyType()->getName(),
            'Collection->getKeyType() return the wrong key type'
        );
    }


    /**
     * Ensure getKeyType() returns a wildcard type
     */
    public function testGetKeyTypeWildcard()
    {
        $this->assertInstanceOf(
            'PHP\\Collections\\Collection\\WildcardType',
            ( new Dictionary( '' ) )->getKeyType(),
            'Expected Collection->getKeyType() to return a wildcard type'
        );
    }




    /***************************************************************************
    *                            Collection->getValues()
    ***************************************************************************/


    /**
     * Ensure getValues() returns a sequence
     * 
     * @dataProvider getCollectionData
     * 
     * @param Collection $collection The collection
     */
    public function testGetValuesReturnType( Collection $collection )
    {
        $this->assertInstanceOf(
            Sequence::class,
            $collection->getValues(),
            'Collection->getValues() should always return a Sequence'
        );
    }


    /**
     * Ensure getValues() returns the correct results
     * 
     * @dataProvider getGetValuesData
     * 
     * @param Collection $collection The collection
     */
    public function testGetValues( Collection $collection, array $expected )
    {
        $this->assertTrue(
            $expected === $collection->getValues()->toArray(),
            'Collection->getValues() didn\'t return the correct results'
        );
    }
    
    
    /**
     * Retrieve test data for getValues() test
     */
    public function getGetValuesData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( 'foo',   'bar' );
        $dictionary->set( 'false', true );
        $dictionary->set( '1',     0 );

        $sequence = new Sequence();
        $sequence->add( 2 );
        $sequence->add( '1' );
        $sequence->add( false );

        return [
            [ $dictionary, [ 'bar', true, 0 ] ],
            [ $sequence,   [ 2, '1', false ] ]
        ];
    }




    /***************************************************************************
    *                          Collection->getValueType()
    ***************************************************************************/


    /**
     * Ensure getValueType() has the same name
     */
    public function testGetValueTypeHasSameName()
    {
        $this->assertEquals(
            'int',
            ( new Dictionary( '', 'integer' ) )->getValueType()->getName(),
            "Collection->getValueType() return the wrong value type"
        );
    }


    /**
     * Ensure getValueType() returns a wildcard type
     */
    public function testGetValueTypeWildcard()
    {
        $this->assertInstanceOf(
            'PHP\\Collections\\Collection\\WildcardType',
            ( new Dictionary( '', '' ) )->getValueType(),
            'Expected Collection->getValueType() to return a wildcard type'
        );
    }




    /***************************************************************************
    *                            Collection->hasKey()
    ***************************************************************************/


    /**
     * Ensure Collection->hasKey() returns the correct values
     * 
     * @dataProvider getHasKeyData
     * 
     * @param Collection $collection The collection
     * @param mixed      $key        The key to check
     * @param bool       $expected   The expected result
     */
    public function testHasKey( Collection $collection, $key, bool $expected )
    {
        $this->assertTrue(
            $expected === $collection->hasKey( $key ),
            'Collection->hasKey() returned the wrong value'
        );
    }


    /**
     * Retrieve test data for hasKey() test
     * 
     * @todo Test Dictionary->hasKey() with mixure of strings and integers
     */
    public function getHasKeyData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( 'foo',   'bar' );
        $dictionary->set( 'false', true );
        $dictionary->set( '1',     0 );

        $sequence = new Sequence();
        $sequence->add( 2 );
        $sequence->add( '1' );
        $sequence->add( false );

        return [
            [ $dictionary, 'false',         true ],
            [ $dictionary, 'dog',           false ],
            [ $dictionary, new \stdClass(), false ],
            [ $sequence,   0,               true ],
            [ $sequence,   5,               false ],
            [ $sequence,   new \stdClass(), false ]
        ];
    }




    /***************************************************************************
    *                            Collection->hasValue()
    ***************************************************************************/


    /**
     * Ensure Collection->hasValue() returns the correct values
     * 
     * @dataProvider getHasValueData
     * 
     * @param Collection $collection The collection
     * @param mixed      $value      The value to check
     * @param bool       $expected   The expected result
     */
    public function testHasValue( Collection $collection, $value, bool $expected )
    {
        $this->assertTrue(
            $expected === $collection->hasValue( $value ),
            'Collection->hasValue() returned the wrong value'
        );
    }


    /**
     * Retrieve test data for hasValue() test
     * 
     * @todo Test Dictionary->hasValue() with mixure of strings and integers
     */
    public function getHasValueData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( 'foo',   'bar' );
        $dictionary->set( 'false', true );
        $dictionary->set( '1',     0 );

        $sequence = new Sequence();
        $sequence->add( 2 );
        $sequence->add( '1' );
        $sequence->add( false );

        return [
            [ $dictionary, true,  true ],
            [ $dictionary, false, false ],
            [ $sequence,   false, true ],
            [ $sequence,   1,     false ]
        ];
    }




    /***************************************************************************
    *                            Collection->loop()
    ***************************************************************************/


    /**
     * Test loop() breaks
     * 
     * @dataProvider getLoopData
     * 
     * @param Collection $collection The collection
     * @param array      $keys       The expected keys
     * @param array      $values     The expected values
     */
    public function testLoopBreaks( Collection $collection,
                                    array      $keys,
                                    array      $values )
    {
        $count = 0;
        $collection->loop(function( $key, $value ) use ( &$count ) {
            $count++;
            return false;
        });

        $expected = ( count( $keys ) === 0 ) ? 0 : 1;
        $this->assertEquals(
            $expected,
            $count,
            'Collection->loop() did not break early'
        );
    }


    /**
     * Test loop() keys
     * 
     * @dataProvider getLoopData
     * 
     * @param Collection $collection The collection
     * @param array      $keys       The expected keys
     * @param array      $values     The expected values
     */
    public function testLoopKeys( Collection $collection,
                                  array      $keys,
                                  array      $values )
    {
        $index = 0;
        $collection->loop( function( $key, $value ) use ( &$index, $keys )
        {
            // Breaking early keeps the index is pointing to a valid key index
            if ( $key !== $keys[ $index ] ) {
                return false;
            }
            $index++;
        });

        // Ensure that the loop finished iterating through ALL the expected keys
        $this->assertTrue(
            !array_key_exists( $index, $keys ),
            'Collection->loop() did not iterate through all the keys'
        );
    }


    /**
     * Test loop() values
     * 
     * @dataProvider getLoopData
     * 
     * @param Collection $collection The collection
     * @param array      $keys       The expected keys
     * @param array      $values     The expected values
     */
    public function testLoopValues( Collection $collection,
                                    array      $keys,
                                    array      $values )
    {
        $index = 0;
        $collection->loop( function( $key, $value ) use ( &$index, $values )
        {
            // Breaking early keeps the index is pointing to a valid value index
            if ( $value !== $values[ $index ] ) {
                return false;
            }
            $index++;
        });

        // Ensure that the loop finished iterating through ALL the expected values
        $this->assertTrue(
            !array_key_exists( $index, $values ),
            'Collection->loop() did not iterate through all the values'
        );
    }


    /**
     * Retrieve test data for testing loop keys and values
     * 
     * @return array
     */
    public function getLoopData()
    {
        $dictionary = new Dictionary();
        $dictionary->set( '1', 1 );
        $dictionary->set( '2', 2 );
        $dictionary->set( '3', 3 );

        $sequence = new Sequence();
        $sequence->add( '0' );
        $sequence->add( '1' );
        $sequence->add( '2' );


        return [

            // Empty collections
            'Empty Dictionary' => [
                new Dictionary(), [], []
            ],
            'Empty Sequence' => [
                new Sequence(),   [], []
            ],

            // Non-empty collections
            'Dictionary string => int' => [
                $dictionary, [ '1', '2', '3' ], [ 1, 2, 3 ]
            ],
            'Sequence int => string' => [
                $sequence,   [ 0, 1, 2 ],       [ '0', '1', '2' ]
            ],
        ];
    }




    /***************************************************************************
    *                         Collection->isOfKeyType()
    ***************************************************************************/


    /**
     * Ensure isOfKeyType throws an error
     **/
    public function testIsOfKeyTypeThrowsDeprecatedError()
    {
        $isError = false;
        try {
            $collection = new \PHP\Collections\Sequence();
            $collection->isOfKeyType( 'int' );
        }
        catch ( \Exception $e ) {
            $isError = true;
        }
        $this->assertTrue(
            $isError,
            'Ensure Collection->isOfKeyType() throws a deprecation error'
        );
    }
    
    
    
    
    /***************************************************************************
    *                         Collection->isOfValueType()
    ***************************************************************************/


    /**
     * Ensure isOfValueType throws an error
     **/
    public function testIsOfValueTypeThrowsDeprecatedError()
    {
        $isError = false;
        try {
            $collection = new \PHP\Collections\Sequence();
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
    
    
    
    
    /***************************************************************************
    *                           Collection->remove()
    ***************************************************************************/
    
    /**
     * Ensure remove() has smaller count
     */
    public function testRemoveHasSmallerCount()
    {
        foreach ( CollectionData::Get() as $collection ) {
            $previous = $collection->count();
            if ( 0 === $previous ) {
                continue;
            }
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
    *                              Collection->set()
    ***************************************************************************/
    
    
    /**
     * Ensure set() with a new key works
     */
    public function testSetNewKey()
    {
        foreach ( CollectionData::Get() as $collection ) {
            if ( 0 === $collection->count() ) {
                continue;
            }
            
            // Get first key and value
            $key   = null;
            $value = null;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
            $collection->clear();
            
            // Test if set works
            $collection->set( $key, $value );
            $name = self::getClassName( $collection );
            $this->assertGreaterThan(
                0,
                $collection->count(),
                "Expected {$name}->set() to set a new key"
            );
        }
    }
    
    
    /**
     * Ensure set() with an existing key works
     */
    public function testSetExistingKey()
    {
        foreach ( CollectionData::Get() as $collection ) {
            
            // Continue on. This collection has no data.
            if ( $collection->count() === 0 ) {
                continue;
            }
            
            // Set first key to last value
            $key   = null;
            $value = null;
            $collection->loop( function( $k, $v ) use ( &$key, &$value ) {
                if ( null === $key ) {
                    $key = $k;
                }
                $value = $v;
            });
            $collection->set( $key, $value );
            
            // Assert test
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $value,
                $collection->get( $key ),
                "Expected {$name}->set() to set an existing entry"
            );
        }
    }
    
    
    /**
     * Ensure set() errors when given wrong key type
     */
    public function testSetErrorsOnWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $key;
            $value;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
            
            $isError = false;
            try {
                $collection->set( $value, $value );
            } catch (\Exception $e) {
                $isError = true;
            }
            
            $name = self::getClassName( $collection );
            $this->assertTrue(
                $isError,
                "Expected {$name}->set() to error on keys with the wrong type"
            );
        }
    }
    
    
    /**
     * Ensure set() rejects keys of the wrong type
     */
    public function testSetRejectsWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $key;
            $value;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
            try {
                $collection->set( $value, $value );
            } catch (\Exception $e) {}
            
            $name = self::getClassName( $collection );
            $this->assertFalse(
                $collection->hasKey( $value ),
                "Expected {$name}->set() to reject keys with the wrong type"
            );
        }
    }
    
    
    /**
     * Ensure set() errors when given wrong value type
     */
    public function testSetErrorsOnWrongValueType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $key;
            $value;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
            
            $isError = false;
            try {
                $collection->set( $key, $key );
            } catch (\Exception $e) {
                $isError = true;
            }
            
            $name = self::getClassName( $collection );
            $this->assertTrue(
                $isError,
                "Expected {$name}->set() to error on keys with the wrong type"
            );
        }
    }
    
    
    /**
     * Ensure set() rejects values of the wrong type
     */
    public function testSetRejectsWrongValueType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            if ( $collection->count() === 0 ) {
                continue;
            }
            
            $key;
            $value;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
            try {
                $collection->set( $key, $key );
            } catch (\Exception $e) {}
            
            $name = self::getClassName( $collection );
            $this->assertFalse(
                ( $key === $collection->get( $key ) ),
                "Expected {$name}->set() to reject keys with the wrong type"
            );
        }
    }




    /***************************************************************************
    *                             Collection->toArray()
    ***************************************************************************/
    
    /**
     * Ensure Collection->toArray() returns the correct array
     * 
     * @dataProvider getToArrayData
     * 
     * @param Collection $collection The collection to convert to array
     * @param array      $array    The expected array
     */
    public function testToArray( Collection $collection, array $array )
    {
        $this->assertEquals(
            $collection->toArray(),
            $array,
            'Collection->toArray() did not return the expected array'
        );
    }


    /**
     * Provides data for array tests
     * 
     * @return array
     */
    public function getToArrayData(): array
    {
        $data = [];

        // Empty sequence
        $data[ 'Empty Sequence' ] = [  new Sequence(), [] ];

        // Non-empty Sequence
        $sequence = new Sequence();
        $sequence->add( 0 );
        $sequence->add( '1' );
        $data[ 'Non-empty Sequence' ] = [
            $sequence,
            [
                0 => 0,
                1 => '1'
            ]
        ];

        // Empty dictionary
        $data[ 'Empty Dictionary' ] = [  new Dictionary(), [] ];

        // Non-empty dictionary
        $dictionary = new Dictionary();
        $dictionary->set( 'foo', 'bar' );
        $dictionary->set(     1,   '1' );
        $data[ 'Non-empty Dictionary' ] = [
            $dictionary,
            [
                'foo' => 'bar',
                    1 => '1'
            ]
        ];

        return $data;
    }




    /***************************************************************************
    *                           Collection Test Data
    ***************************************************************************/


    /**
     * Retrieve collection data
     * 
     * @return array
     */
    public function getCollectionData(): array
    {
        return [
            'Dictionary' => [ new Dictionary() ],
            'Sequence'   => [ new Sequence() ]
        ];
    }




    /***************************************************************************
    *                            Iterator->current()
    ***************************************************************************/


    /**
     * Ensure Collection->current() returns the correct value
     * 
     * @dataProvider getTestCurrentData
     * 
     * @param Collection $collection The collection to test
     * @param mixed      $expected   The expected value from current()
     */
    public function testCurrent( Collection $collection, $expected )
    {
        $this->assertEquals(
            $expected,
            $collection->current(),
            'Collection->current() didn\'t return the correct result'
        );
    }


    /**
     * Retrieve data for Collection->current() test
     * 
     * @return array
     */
    public function getTestCurrentData(): array
    {
        $validDictionaryPosition = new Dictionary();
        $validDictionaryPosition->set( 0, 'foo' );
        $validDictionaryPosition->set( 1, 'bar' );
        $validDictionaryPosition->next();

        $invalidDictionaryPosition = new Dictionary();
        $invalidDictionaryPosition->set( 0, 'foo' );
        $invalidDictionaryPosition->set( 1, 'bar' );
        $invalidDictionaryPosition->next();
        $invalidDictionaryPosition->next();
        
        $validSequencePosition = new Sequence();
        $validSequencePosition->add( 'foo' );
        $validSequencePosition->add( 'bar' );
        $validSequencePosition->add( 'baz' );
        $validSequencePosition->next();
        $validSequencePosition->next();

        $invalidSequencePosition = new Sequence();
        $invalidSequencePosition->add( 'foo' );
        $invalidSequencePosition->add( 'bar' );
        $invalidSequencePosition->next();
        $invalidSequencePosition->next();

        return [

            /**
             * All collections with a bad current() should return false
             * (This is the default functionality of arrays)
             */
            'Dictionary with no entries'        => [
                ( new Dictionary() ), false
            ],
            'Sequence with no entries'          => [
                ( new Sequence() ), false
            ],
            'Dictionary without current()' => [
                $invalidDictionaryPosition, false
            ],
            'Sequence without current()'   => [
                $invalidSequencePosition, false
            ],

            // Valid current
            'Dictionary with current()' => [ $validDictionaryPosition, 'bar' ],
            'Sequence with current()'   => [ $validSequencePosition,   'baz' ]
        ];
    }




    /***************************************************************************
    *                            Iterator->key()
    ***************************************************************************/


    /**
     * Ensure Collection->key() returns the correct value
     * 
     * @dataProvider getTestKeyData
     * 
     * @param Collection $collection The collection to test
     * @param mixed      $expected   The expected value from key()
     */
    public function testKey( Collection $collection, $expected )
    {
        $this->assertEquals(
            $expected,
            $collection->key(),
            'Collection->key() didn\'t return the correct result'
        );
    }


    /**
     * Retrieve data for Collection->key() test
     * 
     * @return array
     */
    public function getTestKeyData(): array
    {
        $validDictionaryPosition = new Dictionary();
        $validDictionaryPosition->set( 0, 'foo' );
        $validDictionaryPosition->set( 1, 'bar' );
        $validDictionaryPosition->next();

        $invalidDictionPosition = new Dictionary();
        $invalidDictionPosition->set( 0, 'foo' );
        $invalidDictionPosition->set( 1, 'bar' );
        $invalidDictionPosition->next();
        $invalidDictionPosition->next();
        
        $validSequencePosition = new Sequence();
        $validSequencePosition->add( 'foo' );
        $validSequencePosition->add( 'bar' );
        $validSequencePosition->add( 'baz' );
        $validSequencePosition->next();
        $validSequencePosition->next();

        $invalidSequencePosition = new Sequence();
        $invalidSequencePosition->add( 'foo' );
        $invalidSequencePosition->add( 'bar' );
        $invalidSequencePosition->next();
        $invalidSequencePosition->next();

        return [

            /**
             * All collections with a bad key() should return NULL
             * (This is the default functionality of arrays)
             */
            'Dictionary with no entries' => [
                ( new Dictionary() ), NULL
            ],
            'Sequence with no entries'   => [
                ( new Sequence() ), NULL
            ],
            'Dictionary without key()'   => [
                $invalidDictionPosition, NULL
            ],
            'Sequence without key()'     => [
                $invalidSequencePosition, NULL
            ],

            // Valid key
            'Dictionary with key()' => [ $validDictionaryPosition, 1 ],
            'Sequence with key()'   => [ $validSequencePosition,   2 ]
        ];
    }




    /***************************************************************************
    *                             Iterator->next()
    *
    * No need to test this. The only way to test this is to check current()
    * after next(). This has already been done in current().
    ***************************************************************************/




    /***************************************************************************
    *                            Iterator->rewind()
    ***************************************************************************/


    /**
     * Ensure Collection->rewind() resets to the correct key
     * 
     * @dataProvider getTestRewindData
     * 
     * @param Collection $collection The collection to test
     * @param mixed      $expected   The expected key after rewind()
     */
    public function testRewind( Collection $collection, $expected )
    {
        $this->assertEquals(
            $expected,
            $collection->rewind(),
            'Collection->rewind() didn\'t reset to the correct key'
        );
    }


    /**
     * Retrieve data for Collection->rewind() test
     * 
     * @return array
     */
    public function getTestRewindData(): array
    {
        $dictionary = new Dictionary();
        $dictionary->set( 0, 'foo' );
        $dictionary->set( 1, 'bar' );
        $dictionary->next();

        $sequence = new Sequence();
        $sequence->add( 'foo' );
        $sequence->add( 'bar' );
        $sequence->add( 'baz' );
        $sequence->next();
        $sequence->next();

        return [

            /**
             * All collections with a bad key() should return NULL
             * (This is the default functionality of arrays)
             */
            'Dictionary with no entries' => [ ( new Dictionary() ), NULL ],
            'Sequence with no entries'   => [ ( new Sequence() ),   NULL ],

            // Valid rewind
            'Dictionary with entries' => [ $dictionary, 0 ],
            'Sequence with entries'   => [ $sequence,   0 ]
        ];
    }




    /***************************************************************************
    *                            Iterator->valid()
    ***************************************************************************/


    /**
     * Ensure Collection->valid() returns the correct result
     * 
     * @dataProvider getTestValidData
     * 
     * @param Collection $collection The collection to test
     * @param mixed      $expected   The expected result from valid()
     */
    public function testValid( Collection $collection, $expected )
    {
        $this->assertEquals(
            $expected,
            $collection->valid(),
            'Collection->valid() didn\'t return the correct result'
        );
    }


    /**
     * Retrieve data for Collection->valid() test
     * 
     * @return array
     */
    public function getTestValidData(): array
    {
        $validDictionaryPosition = new Dictionary();
        $validDictionaryPosition->set( 0, 'foo' );
        $validDictionaryPosition->set( 1, 'bar' );
        $validDictionaryPosition->next();

        $invalidDictionaryPosition = new Dictionary();
        $invalidDictionaryPosition->set( 0, 'foo' );
        $invalidDictionaryPosition->set( 1, 'bar' );
        $invalidDictionaryPosition->next();
        $invalidDictionaryPosition->next();
        
        $validSequencePosition = new Sequence();
        $validSequencePosition->add( 'foo' );
        $validSequencePosition->add( 'bar' );
        $validSequencePosition->add( 'baz' );
        $validSequencePosition->next();
        $validSequencePosition->next();

        $invalidSequencePosition = new Sequence();
        $invalidSequencePosition->add( 'foo' );
        $invalidSequencePosition->add( 'bar' );
        $invalidSequencePosition->next();
        $invalidSequencePosition->next();

        return [

            // Invalid position
            'Dictionary with no entries' => [
                ( new Dictionary() ), false
            ],
            'Sequence with no entries'   => [
                ( new Sequence() ), false
            ],
            'Dictionary at bad position' => [
                $invalidDictionaryPosition, false
            ],
            'Sequence at bad position'   => [
                $invalidSequencePosition, false
            ],

            // Valid position
            'Dictionary at good position' => [ $validDictionaryPosition, true ],
            'Sequence at good position'   => [ $validSequencePosition,   true ]
        ];
    }
}
