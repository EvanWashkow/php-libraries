<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\Cache;
use PHP\Collections\Collection;
use PHP\Collections\Dictionary;
use PHP\Collections\IArrayable;
use PHP\Collections\ICountable;
use PHP\Collections\Iteration\IIterable;
use PHP\Collections\KeyValuePair;
use PHP\Collections\Sequence;
use PHP\Exceptions\NotFoundException;
use PHP\Interfaces\ICloneable;
use PHP\Types\Models\AnonymousType;
use PHPUnit\Framework\TestCase;

require_once( __DIR__ . '/CollectionData.php' );

/**
 * Test all Collection methods to ensure consistent functionality
 */
class CollectionTest extends TestCase
{




    /***************************************************************************
    *                                 INHERITANCE
    ***************************************************************************/

    /**
     * Test inheritance
     * 
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance( string $expectedParent )
    {
        $this->assertInstanceOf(
            $expectedParent,
            $this->createMock( Collection::class ),
            "Collection is not of type \\{$expectedParent}."
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            IArrayable::class => [ IArrayable::class ],
            ICloneable::class => [ ICloneable::class ],
            ICountable::class => [ ICountable::class ],
            IIterable::class  => [ IIterable::class ]
        ];
    }




    /***************************************************************************
    *                           Collection->__construct()
    ***************************************************************************/


    /**
     * Ensure the constructor throws an error for null key types
     * 
     * @dataProvider getConstructorExceptionsData
     * 
     * @param Closure $function Function callback with the exceptions
     **/
    public function testConstructorExceptions( \Closure $function )
    {
        $this->expectException(\DomainException::class);
        $function();
    }


    /**
     * Get test data for testing constructor throws exception on bad key
     * 
     * @return array
     */
    public function getConstructorExceptionsData(): array
    {
        return [

            // Dictionary
            "new Dictionary( '', 'int' )" => [
                function () { new Dictionary( '', 'int' ); }
            ],
            "new Dictionary( 'int', '' )" => [
                function () { new Dictionary( 'int', '' ); }
            ],
            'new Dictionary( null )'   => [
                function () { new Dictionary( 'null', '*' ); }
            ],
            'new Dictionary( foobar )' => [
                function () { new Dictionary( 'foobar', '*' ); }
            ],
            'new Dictionary( *, null )'   => [
                function () { new Dictionary( '*', 'null' ); }
            ],
            'new Dictionary( *, foobar )' => [
                function () { new Dictionary( '*', 'foobar' ); }
            ],

            // Sequence
            "new Sequence( '' )" => [
                function () { new Sequence( '' ); }
            ],
            'new Sequence( null )'   => [
                function () { new Sequence( 'null' ); }
            ],
            'new Sequence( foobar )' => [
                function () { new Sequence( 'foobar' ); }
            ],
        ];
    }


    /**
     * Ensure the constructor sets initial entries
     * 
     * @dataProvider getConstructorEntriesData
     * 
     * @param Collection $collection The collection instance
     * @param array      $expected   The expected entries
     **/
    public function testConstructorEntries( Collection $collection,
                                            array      $expected )
    {
        $this->assertEquals(
            $expected,
            $collection->toArray(),
            'Collection constructor did not set the initial entries'
        );
    }


    /**
     * Get test data for testing constructor sets initial entries
     * 
     * @return array
     */
    public function getConstructorEntriesData(): array
    {
        set_error_handler(function() {});
        $array = [

            // Dictionary
            'Dictionary with no entries' => [
                new Dictionary('string', 'string', []), []
            ],
            'Dictionary with entries' => [
                new Dictionary('string', 'string', [ 'foo' => 'bar' ]),
                [ 'foo' => 'bar' ]
            ],
            'Dictionary with wrong key type' => [
                new Dictionary('int', 'string', [ 'foo' => 'bar' ]),
                []
            ],
            'Dictionary with wrong value type' => [
                new Dictionary('string', 'int', [ 'foo' => 'bar' ]),
                []
            ],

            // Cache
            'Cache with no entries' => [
                new Cache('string', 'string', []), []
            ],
            'Cache with entries' => [
                new Cache('string', 'string', [ 'foo' => 'bar' ]),
                [ 'foo' => 'bar' ]
            ],
            'Cache with wrong key type' => [
                new Cache('int', 'string', [ 'foo' => 'bar' ]),
                []
            ],
            'Cache with wrong value type' => [
                new Cache('string', 'int', [ 'foo' => 'bar' ]),
                []
            ],

            // Sequence
            'Sequence with no entries' => [
                new Sequence( 'string', []), []
            ],
            'Sequence with entries' => [
                new Sequence( 'string', [ 5 => 'bar' ]),
                [ 0 => 'bar' ]
            ],
            'Sequence with wrong value type' => [
                new Sequence( 'string', [ 5, 'foo' => 'bar' ]),
                [ 0 => 'bar' ]
            ],
            'Anonymous Sequence with entries' => [
                new Sequence( '*', [ 5 => 'bar' ]),
                [ 0 => 'bar' ]
            ],
        ];
        restore_error_handler();
        return $array;
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
            $name = get_class( $collection );
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
     * Ensure shallow clone $this has the same entries
     * 
     * @dataProvider getCloneEntriesData
     * 
     * @param Collection $collection The collection to clone
     * @param array      $expected   The expected entries
     */
    public function testShallowCloneEntries( Collection $collection,
                                             array      $expected )
    {
        $clone = clone $collection;
        $this->assertEquals(
            $expected,
            $clone->toArray(),
            'The cloned collection does not have the same entries'
        );
    }


    /**
     * Retrieve test data for testing that clone rewinds the collection
     * 
     * @return array
     */
    public function getCloneEntriesData(): array
    {
        return [

            // Dictionary
            'Empty Dictionary' => [
                new Dictionary( '*', '*' ),
                []
            ],
            'Non-empty Dictionary' => [
                new Dictionary( '*', '*', [
                    'foo' => 'bar',
                    'biz' => 'baz'
                ]),
                [
                    'foo' => 'bar',
                    'biz' => 'baz'
                ]
            ],

            // Sequence
            'Empty Sequence' => [
                new Sequence( '*' ),
                []
            ],
            'Non-empty Sequence' => [
                new Sequence( '*', [
                    'foo',
                    'bar',
                    'biz',
                    'baz'
                ]),
                [
                    'foo',
                    'bar',
                    'biz',
                    'baz'
                ]
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
        $dictionary = new Dictionary( '*', '*' );
        $dictionary->set( 0, 0 );
        $dictionary->set( 1, 1 );
        $dictionary->set( 2, 2 );

        $sequence = new Sequence( '*' );
        $sequence->add( 0 );
        $sequence->add( 1 );
        $sequence->add( 2 );

        return [
            [ ( new Dictionary( '*', '*' ) ), 0 ],
            [ $dictionary,          3 ],
            [ ( new Sequence( '*' ) ),   0 ],
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
        $dictionary = new Dictionary( '*', '*' );
        $dictionary->set( 0, 'foo' );
        $dictionary->set( 1, true );
        $dictionary->set( 2, 'bar' );

        $sequence = new Sequence( '*' );
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
     * @dataProvider getGetExceptionData
     * 
     * @param Collection $collection The collection to test
     * @param mixed      $key        The key to access
     **/
    public function testGetException( Collection $collection, $key )
    {
        $this->expectException(\OutOfBoundsException::class);
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
            [ new Dictionary( '*', '*' ), null ],
            [ new Sequence( '*' ),   null ],
            

            // Missing keys
            [ new Dictionary( '*', '*' ), 0 ],
            [ new Sequence( '*' ),   0 ],

            // Wrong key type
            [ $dictionary, '0' ],
            [ $sequence,   '0' ]
        ];
    }




    /***************************************************************************
    *                            Collection->getKeyOf()
    ***************************************************************************/


    /**
     * Ensure getKeyOf() throws exceptions when expected
     * 
     * @dataProvider getGetKeyOfExceptionsData
     *
     * @param Collection $sequence The collection
     * @param mixed      $badValue A bad value to try to find
     **/
    public function testGetKeyOfExceptions(
        Collection $collection,
        $badValue
    ) {
        $this->expectException(NotFoundException::class);
        $collection->getKeyOf( $badValue );
    }


    /**
     * Retrieve test data for the getKeyOf() result test
     *
     * @return array
     **/
    public function getGetKeyOfExceptionsData(): array
    {
        $dictionary = new Dictionary( '*', '*' );
        $dictionary->set( '0', 0 );
        $dictionary->set( '1', 1 );

        $sequence = new Sequence( '*' );
        $sequence->add( 0 );
        $sequence->add( 1 );

        return [

            // Dictionary
            'Empty Dictionary; missing value' => [
                new Dictionary( '*', '*' ), 0
            ],
            'Non-empty Dictionary; missing value' => [
                $dictionary, 2
            ],
            'Non-empty Dictionary; wrong value type' => [
                $dictionary, '0'
            ],

            // Sequence
            'Empty Sequence; missing value' => [
                new Sequence( '*' ), 0
            ],
            'Non-empty Sequence; missing value' => [
                $sequence, 2
            ],
            'Non-empty Sequence; wrong value type' => [
                $sequence, '0'
            ]
        ];
    }


    /**
     * Test getKeyOf() result
     * 
     * @dataProvider getGetKeyOfResultData
     *
     * @param Collection $sequence The collection
     * @param mixed      $value    The value to get the key of
     * @param mixed      $expected The expected key
     **/
    public function testGetKeyOfResult( Collection $collection,
                                                   $value,
                                                   $expected )
    {
        $this->assertEquals( $collection->getKeyOf( $value ), $expected );
    }


    /**
     * Retrieve test data for the getKeyOf() result test
     *
     * @return array
     **/
    public function getGetKeyOfResultData(): array
    {
        $dictionary = new Dictionary( '*', '*' );
        $dictionary->set( '0', 0 );
        $dictionary->set( '1', 1 );

        $sequence = new Sequence( '*' );
        $sequence->add( 0 );
        $sequence->add( 1 );

        return [

            // Dictionary
            'Dictionary; value 0' => [
                $dictionary, 0, '0'
            ],
            'Dictionary; value 1' => [
                $dictionary, 1, '1'
            ],

            // Sequence
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
        $this->assertEquals(
            $expected,
            $collection->getKeys()->toArray(),
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
        return [
            [
                new Dictionary( '*', '*', [
                    'foo'   => 'bar',
                    'false' => true,
                    '1'     => 0
                ]),
                [ 'foo', 'false', '1' ]
            ],
            [
                new Sequence( '*', [ 2, '1', false ] ),
                [ 0, 1, 2 ]
            ]
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
            ( new Dictionary( 'integer', '*' ) )->getKeyType()->getName(),
            'Collection->getKeyType() return the wrong key type'
        );
    }


    /**
     * Ensure getKeyType() returns a Anonymous type
     */
    public function testGetKeyTypeAnonymous()
    {
        $this->assertInstanceOf(
            AnonymousType::class,
            ( new Dictionary( '*', '*' ) )->getKeyType(),
            'Expected Collection->getKeyType() to return a Anonymous type'
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
        $this->assertEquals(
            $expected,
            $collection->getValues()->toArray(),
            'Collection->getValues() didn\'t return the correct results'
        );
    }
    
    
    /**
     * Retrieve test data for getValues() test
     */
    public function getGetValuesData(): array
    {
        return [
            [
                new Dictionary( '*', '*', [
                    'foo'   => 'bar',
                    'false' => true,
                    '1'     => 0
                ]),
                [ 'bar', true, 0 ]
            ],
            [
                new Sequence( '*', [ 2, '1', false ] ),
                [ 2, '1', false ]
            ]
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
            ( new Dictionary( '*', 'integer' ) )->getValueType()->getName(),
            "Collection->getValueType() return the wrong value type"
        );
    }


    /**
     * Ensure getValueType() returns a Anonymous type
     */
    public function testGetValueTypeAnonymous()
    {
        $this->assertInstanceOf(
            AnonymousType::class,
            ( new Dictionary( '*', '*' ) )->getValueType(),
            'Expected Collection->getValueType() to return a Anonymous type'
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
        $dictionary = new Dictionary( '*', '*' );
        $dictionary->set( 'false', true );
        $dictionary->set( '1',     0 );
        $dictionary->set( 'foobar', 'foobar' );

        $sequence = new Sequence( '*' );
        $sequence->add( 2 );
        $sequence->add( '1' );
        $sequence->add( false );

        return [
            'Dictionary valid'    => [ $dictionary, 'false',         true ],
            'Dictionary bad type' => [ $dictionary, new \stdClass(), false ],
            'Dictionary partial'  => [ $dictionary, 'foo',           false ],
            'Sequence valid'      => [ $sequence,   0,               true ],
            'Sequence unknown'    => [ $sequence,   5,               false ],
            'Sequence bad type'   => [ $sequence,   new \stdClass(), false ]
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
        $dictionary = new Dictionary( '*', '*' );
        $dictionary->set( 'false',  true );
        $dictionary->set( '1',      0 );
        $dictionary->set( 'foobar', 'foobar' );
        
        $sequence = new Sequence( '*' );
        $sequence->add( 2 );
        $sequence->add( '1' );
        $sequence->add( false );
        $sequence->add( 'foobar' );

        return [
            'Dictionary valid'          => [ $dictionary, true,  true ],
            'Dictionary type-sensitive' => [ $dictionary, '0',   false ],
            'Dictionary partial'        => [ $dictionary, 'foo', false ],
            'Sequence valid'            => [ $sequence,   false, true ],
            'Sequence type-sensitive'   => [ $sequence,   1,     false ],
            'Sequence partial'          => [ $sequence,   'foo', false ]
        ];
    }
    
    
    
    
    /***************************************************************************
    *                           Collection->remove()
    ***************************************************************************/


    /**
     * Ensure remove() has the expected entries
     * 
     * @dataProvider getRemoveKeyEntriesData
     * 
     * @param Collection $collection   The collection to remove keys from
     * @param array      $keysToRemove The keys to remove
     * @param array      $expected     The expected entries
     */
    public function testRemoveKeyEntries( Collection $collection,
                                          array      $keysToRemove,
                                          array      $expected )
    {
        foreach ( $keysToRemove as $key ) {
            $collection->remove( $key );
        }
        $this->assertEquals(
            $expected,
            $collection->toArray(),
            'Collection->remove() did not remove the key'
        );
    }


    /**
     * Get test data for removing key entries
     */
    public function getRemoveKeyEntriesData(): array
    {
        return [
            'Dictionary' => [
                new Dictionary( '*', 'string', [
                    '0'   => '1',
                    'foo' => 'bar',
                    'biz' => 'baz'
                ]),
                [ '0', 'foo' ],
                [ 'biz' => 'baz' ]
            ],
            'Sequence' => [
                new Sequence( 'string', [
                    'foo',
                    'bar',
                    'biz',
                    'baz'
                ]),
                [ 0, 1 ],
                [ 'bar', 'baz' ]
            ]
        ];
    }


    /**
     * Ensure remove() produces errors
     * 
     * @dataProvider getRemoveKeyErrorsData
     * 
     * @param Collection $collection   The collection to remove keys from
     * @param mixed      $keyToRemove  The key to remove
     */
    public function testRemoveKeyErrors( Collection $collection, $keyToRemove )
    {
        $isError;
        try {
            $collection->remove( $keyToRemove );
            $isError = false;
        } catch (\Throwable $th) {
            $isError = true;
        }
        $this->assertTrue(
            $isError,
            'Collection->remove() did not produce error for missing key'
        );
    }


    /**
     * Get data for testing remove() errors
     */
    public function getRemoveKeyErrorsData(): array
    {
        return [
            'Dictionary: non-existing key' => [
                new Dictionary( '*', 'string', [
                    '0'   => '1',
                    'foo' => 'bar',
                    'biz' => 'baz'
                ]),
                'baz'
            ],
            'Sequence: non-existing key' => [
                new Sequence( 'string', [
                    'foo',
                    'bar',
                    'biz',
                    'baz'
                ]),
                4
            ]
        ];
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
            foreach ( $collection as $k => $v ) {
                if ( $v instanceof KeyValuePair ) {
                    $k = $v->getKey();
                    $v = $v->getValue();
                }
                $key   = $k;
                $value = $v;
                break;
            }
            $collection->clear();
            
            // Test if set works
            $collection->set( $key, $value );
            $name = get_class( $collection );
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
            foreach ( $collection as $k => $v ) {
                if ( $v instanceof KeyValuePair ) {
                    $k = $v->getKey();
                    $v = $v->getValue();
                }
                if ( null === $key ) {
                    $key = $k;
                }
                $value = $v;
            }
            $collection->set( $key, $value );
            
            // Assert test
            $name = get_class( $collection );
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
            foreach ( $collection as $k => $v ) {
                if ( $v instanceof KeyValuePair ) {
                    $k = $v->getKey();
                    $v = $v->getValue();
                }
                $key   = $k;
                $value = $v;
                break;
            }
            
            $isError = false;
            try {
                $collection->set( $value, $value );
            } catch (\Exception $e) {
                $isError = true;
            }
            
            $name = get_class( $collection );
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
            $key   = null;
            $value = null;
            foreach ( $collection as $k => $v ) {
                if ( $v instanceof KeyValuePair ) {
                    $k = $v->getKey();
                    $v = $v->getValue();
                }
                $key   = $k;
                $value = $v;
                break;
            }
            try {
                $collection->set( $value, $value );
            } catch (\Exception $e) {}
            
            $name = get_class( $collection );
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
            foreach ( $collection as $k => $v ) {
                if ( $v instanceof KeyValuePair ) {
                    $k = $v->getKey();
                    $v = $v->getValue();
                }
                $key   = $k;
                $value = $v;
                break;
            }
            
            $isError = false;
            try {
                $collection->set( $key, $key );
            } catch (\Exception $e) {
                $isError = true;
            }
            
            $name = get_class( $collection );
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
            foreach ( $collection as $k => $v ) {
                if ( $v instanceof KeyValuePair ) {
                    $k = $v->getKey();
                    $v = $v->getValue();
                }
                $key   = $k;
                $value = $v;
                break;
            }
            try {
                $collection->set( $key, $key );
            } catch (\Exception $e) {}
            
            $name = get_class( $collection );
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
        $data[ 'Empty Sequence' ] = [  new Sequence( '*' ), [] ];

        // Non-empty Sequence
        $sequence = new Sequence( '*' );
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
        $data[ 'Empty Dictionary' ] = [  new Dictionary( '*', '*' ), [] ];

        // Non-empty dictionary
        $dictionary = new Dictionary( '*', '*' );
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
            'Dictionary' => [ new Dictionary( '*', '*' ) ],
            'Sequence'   => [ new Sequence( '*' ) ]
        ];
    }
}
