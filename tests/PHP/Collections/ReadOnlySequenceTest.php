<?php

use PHP\Collections\Sequence;
use PHP\Collections\ReadOnlySequence;

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/ReadOnlySequenceData.php' );

/**
 * Test all ReadOnlySequence methods to ensure consistent functionality
 *
 * This tests both the read-only and the editable sequnce (the read-only
 * simply invokes the editable)
 */
class ReadOnlySequenceTest extends \PHP\Tests\Collections\CollectionsTestCase
{
    
    /***************************************************************************
    *                       ReadOnlySequence->toArray()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->toArray() returns an array
     */
    public function testToArrayReturnsArray()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                is( $sequence->toArray(), 'array' ),
                "Expected {$class}->toArray() to return an array"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->toArray() has the same number of elements
     */
    public function testToArrayHasSameCount()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertEquals(
                $sequence->count(),
                count( $sequence->toArray() ),
                "Expected {$class}->toArray() to have the same number of elements"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->getFirstKey()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->getFirstKey() returns zero
     */
    public function testGetFirstKeyReturnsZero()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                0 === $sequence->getFirstKey(),
                "Expected {$class}->getFirstKey() to return zero"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->getLastKey()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->getLastKey() returns an integer value
     */
    public function testGetLastKeyReturnsInt()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                is( $sequence->getLastKey(), 'integer' ),
                "Expected {$class}->getLastKey() to return an integer value"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getLastKey() is larger than or equalt to the
     * first for non-empty
     */
    public function testGetLastKeyIsGreaterThanOrEqualToFirstForNonEmpty()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            if ( $sequence->count() === 0 ) {
                continue;
            }
            $class = self::getClassName( $sequence );
            $this->assertGreaterThanOrEqual(
                $sequence->getFirstKey(),
                $sequence->getLastKey(),
                "Expected {$class}->getLastKey() to be greater than or equal to the first key for non-empty sequences"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getLastKey() is less than first for empty
     */
    public function testGetLastKeyIsLessThanFirstForEmpty()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            if ( 0 < $sequence->count() ) {
                continue;
            }
            $class = self::getClassName( $sequence );
            $this->assertLessThan(
                $sequence->getFirstKey(),
                $sequence->getLastKey(),
                "Expected {$class}->getLastKey() to be less than the first key for empty sequences"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->getKeyOf()
    ***************************************************************************/
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns a bad key when value doesn't exist
     */
    public function testGetKeyOfReturnsBadKeyWhenMissingValue()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertLessThan(
                $sequence->getFirstKey(),
                $sequence->getKeyOf( 'foobar' ),
                "Expected {$class}->getKeyOf() to return a bad key when the value doesn't exist"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() errors on too small of an offset
     */
    public function testGetKeyOfErrorsOnOffsetTooSmall()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $isError = false;
            try {
                $sequence->getKeyOf( 'foobar', $sequence->getFirstKey() - 1 );
            } catch (\Exception $e) {
                $isError = true;
            }
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $isError,
                "Expected {$class}->getKeyOf() to error when given an offset position too small"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *               ReadOnlySequence->getKeyOf() (string data)
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key of the first value
     */
    public function testGetKeyOfStringValueReturnsFirstValueKey()
    {
        foreach ( self::getStringData() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                0 === $sequence->getKeyOf( '0' ),
                "Expected {$class}->getKeyOf() to return the key of the first value"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key of offset value
     */
    public function testGetKeyOfStringValueReturnsKeyOfOffsetSearch()
    {
        foreach ( self::getStringData() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                3 === $sequence->getKeyOf( '0', 1 ),
                "Expected {$class}->getKeyOf() to return the key of the offset value"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key of a reverse search
     */
    public function testGetKeyOfStringValueReturnsKeyOfReverseSearch()
    {
        foreach ( self::getStringData() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                4 === $sequence->getKeyOf( '0', 0, true ),
                "Expected {$class}->getKeyOf() to return the key of the value when searching in reverse"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key in a reversed, offset search
     */
    public function testGetKeyOfStringValueReturnsKeyOfReverseOffsetSearch()
    {
        foreach ( self::getStringData() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                3 === $sequence->getKeyOf( '0', 2, true ),
                "Expected {$class}->getKeyOf() to return the key of the value when searching in reverse with offset"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->reverse()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->reverse() returns the same type
     */
    public function testReverseReturnsSameType()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertEquals(
                get_class( $sequence ),
                get_class( $sequence->reverse() ),
                "Expected {$class}->reverse() to return the same type"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->reverse() has same keys
     */
    public function testReverseHasSameKeys()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class   = self::getClassName( $sequence );
            $lastKey = $sequence->getLastKey();
            $reverse = $sequence->reverse();
            $sequence->loop(function( $key, $value ) use ( $class, $lastKey, $reverse ) {
                $this->assertTrue(
                    $reverse->hasKey( $lastKey - $key ),
                    "Expected {$class}->reverse() to have the same keys"
                );
            });
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->reverse() has the same values in reverse
     */
    public function testReverseValuesAreReversed()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class   = self::getClassName( $sequence );
            $lastKey = $sequence->getLastKey();
            $reverse = $sequence->reverse();
            $sequence->loop(function( $key, $value ) use ( $class, $lastKey, $reverse ) {
                $this->assertEquals(
                    $value,
                    $reverse->get( $lastKey - $key ),
                    "Expected {$class}->reverse() to have the same values in reverse"
                );
            });
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->slice()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->slice() returns same type
     */
    public function testSliceReturnsSameType()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertEquals(
                get_class( $sequence ),
                get_class( $sequence->slice( $sequence->getFirstKey(), $sequence->count() ) ),
                "Expected {$class}->slice() to return same type"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() with offset returns a subset of the same values
     */
    public function testSliceOffsetReturnsValueSubset()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class   = self::getClassName( $sequence );
            $count   = $sequence->count();
            $lastKey = $sequence->getLastKey();
            for ( $offset = $sequence->getFirstKey(); $offset <= $lastKey; $offset++ ) {
                $slice = $sequence->slice( $offset, $count );
                for ( $key = $offset; $key <= $lastKey; $key++ ) {
                    $this->assertTrue(
                        $sequence->get( $key ) === $slice->get( $key - $offset ),
                        "Expected {$class}->slice() with offset to return a subset of the same values"
                    );
                }
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() with count returns a subset of the same values
     */
    public function testSliceCountReturnsValueSubset()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class   = self::getClassName( $sequence );
            $firstKey = $sequence->getFirstKey();
            for ( $count = 0; $count <= $sequence->count(); $count++ ) {
                $slice = $sequence->slice( $firstKey, $count );
                for ( $key = $firstKey; $key <= $slice->getLastKey(); $key++ ) {
                    $this->assertTrue(
                        $sequence->get( $key ) === $slice->get( $key ),
                        "Expected {$class}->slice() with count to return a subset of the same values"
                    );
                }
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() with offset too large returns no values
     */
    public function testSliceWithLargeOffsetReturnsNoValues()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $slice = $sequence->slice( $sequence->getLastKey() + 1, $sequence->count() );
            $this->assertEquals(
                0,
                $slice->count(),
                "Expected {$class}->slice() given an offset too large returns an empty object"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() with count of zero returns no values
     */
    public function testSliceWithCountOfZeroReturnsNoValues()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $slice = $sequence->slice( $sequence->getFirstKey(), 0 );
            $this->assertEquals(
                0,
                $slice->count(),
                "Expected {$class}->slice() with count of zero to return an empty object"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() errors on an offset too small
     */
    public function testSliceErrorsOnSmallOffset()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $isError = false;
            try {
                $sequence->slice( $sequence->getFirstKey() - 1, 0 );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $isError,
                "Expected {$class}->slice() to error on an offset that is too small"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() errors on a negative offset
     */
    public function testSliceErrorsOnNegativeLimits()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $isError = false;
            try {
                $sequence->slice( $sequence->getFirstKey(), -1 );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $isError,
                "Expected {$class}->slice() to error on a negative offset"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->split()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->split() returns same type
     */
    public function testSplitReturnsSameType()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            if ( $sequence->count() === 0 ) {
                continue;
            }
            $value = $sequence->get( $sequence->getFirstKey() );
            $split = $sequence->split( $value );
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                get_class( $sequence ) === get_class( $split ),
                "Expected {$class}->split() to return the same type"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                                   DATA
    ***************************************************************************/
    
    /**
     * Retrieves test data for string tests
     *
     * @return array
     */
    public static function getStringData(): array
    {
        // Variables
        $sequences = [];
        
        // Build test string Sequences
        $sequence = new Sequence( 'string' );
        $sequence->add( '0' );
        $sequence->add( '1' );
        $sequence->add( '1' );
        $sequence->add( '0' );
        $sequence->add( '0' );
        $sequence->add( '1' );
        $sequences[] = $sequence;
        $sequences[] = new ReadOnlySequence( $sequence );
        
        return $sequences;
    }
}
