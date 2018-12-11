<?php
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
}
