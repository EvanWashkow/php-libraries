<?php

require_once( __DIR__ . '/CollectionTestCase.php' );
require_once( __DIR__ . '/ReadOnlySequenceData.php' );

/**
 * Test all ReadOnlySequence methods to ensure consistent functionality
 *
 * This tests both the read-only and the editable sequnce (the read-only
 * simply invokes the editable)
 */
class ReadOnlySequenceTest extends CollectionTestCase
{
    
    /***************************************************************************
    *                       ReadOnlySequence->toArray()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->toArray() returns an array
     */
    public function testToArrayReturnsArray()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    is( $sequence->toArray(), 'array' ),
                    "Expected {$class}->toArray() to return an array"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->toArray() has the same number of elements
     */
    public function testToArrayHasSameCount()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $class = self::getClassName( $sequence );
                $this->assertEquals(
                    $sequence->count(),
                    count( $sequence->toArray() ),
                    "Expected {$class}->toArray() to have the same number of elements"
                );
            }
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
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    0 === $sequence->getFirstKey(),
                    "Expected {$class}->getFirstKey() to return zero"
                );
            }
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->getLastKey()
    ***************************************************************************/
    
    
    /**
     * Ensure ReadOnlySequence->getLastKey() returns one less than count
     */
    public function testGetLastKeyReturnsOneLessThanCount()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    $sequence->getLastKey() === ( $sequence->count() - 1 ),
                    "Expected {$class}->getLastKey() to return one less than count"
                );
            }
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
        $values = CollectionTestData::Get();
        foreach ( ReadOnlySequenceData::Get() as $sequenceType => $sequences ) {
            foreach ( $sequences as $sequence ) {
                foreach ( $values as $valueType => $typedValues ) {
                    $value = $typedValues[ 0 ];
                    if ( '' === $sequenceType ) {
                        $value = 'foobar';
                    }
                    elseif ( $sequenceType === $valueType ) {
                        continue;
                    }
                    $class = self::getClassName( $sequence );
                    $this->assertLessThan(
                        $sequence->getFirstKey(),
                        $sequence->getKeyOf( $value ),
                        "Expected {$class}->getKeyOf() to return a bad key when the value doesn't exist"
                    );
                }
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() errors on too small of an offset
     */
    public function testGetKeyOfErrorsOnOffsetTooSmall()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
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
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key with no offset
     */
    public function testGetKeyOfReturnsKeyWithNoOffset()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $sequence->loop(function( $key, $value ) use ( $sequence ) {
                    $class = self::getClassName( $sequence );
                    $this->assertEquals(
                        $key,
                        $sequence->getKeyOf( $value ),
                        "Expected {$class}->getKeyOf() to return the key of the value with no offset"
                    );
                });
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key when offset at that key
     */
    public function testGetKeyOfReturnsKeyAtThatOffset()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $sequence->loop(function( $key, $value ) use ( $sequence ) {
                    $class = self::getClassName( $sequence );
                    $this->assertEquals(
                        $key,
                        $sequence->getKeyOf( $value, $key ),
                        "Expected {$class}->getKeyOf() to return the key when offset at that key"
                    );
                });
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns bad key with offset too large
     */
    public function testGetKeyOfReturnsBadKeyOnOffsetTooLarge()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $sequence->loop(function( $key, $value ) use ( $sequence ) {
                    $class = self::getClassName( $sequence );
                    $this->assertEquals(
                        $sequence->getFirstKey() - 1,
                        $sequence->getKeyOf( $value, $key + 1 ),
                        "Expected {$class}->getKeyOf() to return a bad key given an offset too large"
                    );
                });
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key with no offset,
     * reversed
     */
    public function testGetKeyOfReturnsKeyWithNoOffsetReversed()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $sequence->loop(function( $key, $value ) use ( $sequence ) {
                    $class = self::getClassName( $sequence );
                    $this->assertEquals(
                        $key,
                        $sequence->getKeyOf( $value, 0, true ),
                        "Expected {$class}->getKeyOf() to return the key of the value with no offset"
                    );
                });
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key when offset at that key,
     * reversed
     */
    public function testGetKeyOfReturnsKeyAtThatOffsetReversed()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $sequence->loop(function( $key, $value ) use ( $sequence ) {
                    $class = self::getClassName( $sequence );
                    $this->assertEquals(
                        $key,
                        $sequence->getKeyOf( $value, $sequence->getLastKey() - $key, true ),
                        "Expected {$class}->getKeyOf() to return the key when offset at that key"
                    );
                });
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns bad key with offset too large,
     * reversed
     */
    public function testGetKeyOfReturnsBadKeyOnOffsetTooLargeReversed()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $sequence->loop(function( $key, $value ) use ( $sequence ) {
                    $class = self::getClassName( $sequence );
                    $this->assertEquals(
                        $sequence->getFirstKey() - 1,
                        $sequence->getKeyOf( $value, $sequence->count() - $key, true ),
                        "Expected {$class}->getKeyOf() to return a bad key given an offset too large"
                    );
                });
            }
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
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ($sequences as $sequence) {
                $class = self::getClassName( $sequence );
                $this->assertEquals(
                    get_class( $sequence ),
                    get_class( $sequence->reverse() ),
                    "Expected {$class}->reverse() to return the same type"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->reverse() has same count
     */
    public function testReverseHasCount()
    {
        foreach (ReadOnlySequenceData::Get() as $type => $sequences) {
            foreach ($sequences as $type => $sequence) {
                $class = self::getClassName( $sequence );
                $this->assertEquals(
                    $sequence->count(),
                    $sequence->reverse()->count(),
                    "Expected {$class}->reverse() to have the same count"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->reverse() has keys
     */
    public function testReverseHasKeys()
    {
        foreach (ReadOnlySequenceData::Get() as $type => $sequences) {
            foreach ($sequences as $type => $sequence) {
                $hasKeys = true;
                $reverse = $sequence->reverse();
                foreach ($sequence as $key => $value) {
                    if ( !$reverse->hasKey( $key ) ) {
                        $hasKeys = false;
                        break;
                    }
                    
                }
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    $hasKeys,
                    "Expected {$class}->reverse() to have the same keys"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->reverse() has the same values in reverse
     */
    public function testReverseValuesAreReversed()
    {
        foreach (ReadOnlySequenceData::Get() as $type => $sequences) {
            foreach ($sequences as $type => $sequence) {
                $hasValues = true;
                $lastKey   = $sequence->getLastKey();
                $reverse   = $sequence->reverse();
                foreach ( $sequence as $key => $value ) {
                    $reverseKey = $lastKey - $key;
                    if (
                        ( !$reverse->hasKey( $reverseKey ) )        ||
                        ( $value !== $reverse->get( $reverseKey ) )
                    ) {
                        $hasValues = false;
                        break;
                    }
                }
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    $hasValues,
                    "Expected {$class}->reverse() to have the same values in reverse"
                );
            }
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
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                $class = self::getClassName( $sequence );
                $this->assertEquals(
                    get_class( $sequence ),
                    get_class( $sequence->slice( $sequence->getFirstKey(), $sequence->count() ) ),
                    "Expected {$class}->slice() to return same type"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() with offset returns a subset of the same values
     */
    public function testSliceOffsetReturnsValueSubset()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ($sequences as $sequence) {
                
                // Variables
                $count     = $sequence->count();
                $lastKey   = $sequence->getLastKey();
                $hasValues = true;
                
                // Increment the offset, checking values from resulting slice
                for ( $offset = $sequence->getFirstKey(); $offset <= $lastKey; $offset++ ) {
                    $slice = $sequence->slice( $offset, $count );
                    for ( $key = $offset; $key <= $lastKey; $key++ ) {
                        if ( $sequence->get( $key ) !== $slice->get( $key - $offset )) {
                            $hasValues = false;
                            break;
                        }
                    }
                }
                
                // Assertion
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    $hasValues,
                    "Expected {$class}->slice() with offset to return a subset of the same values"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() with count returns a subset of the same values
     */
    public function testSliceLimitReturnsValueSubset()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ($sequences as $sequence) {
                $hasValues = true;
                $firstKey   = $sequence->getFirstKey();
                for ( $count = 0; $count <= $sequence->count(); $count++ ) {
                    $slice = $sequence->slice( $firstKey, $count );
                    for ( $key = $firstKey; $key <= $slice->getLastKey(); $key++ ) {
                        if ( $sequence->get( $key ) !== $slice->get( $key )) {
                            $hasValues = false;
                            break;
                        }
                    }
                }
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    $hasValues,
                    "Expected {$class}->slice() with limit to return a subset of the same values"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() with limit returns that many elements
     */
    public function testSliceLimitReturnsLimit()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ($sequences as $sequence) {
                $hasLimit = true;
                $firstKey   = $sequence->getFirstKey();
                for ( $count = 0; $count <= $sequence->count(); $count++ ) {
                    $slice = $sequence->slice( $firstKey, $count );
                    if ( $count !== $slice->count() ) {
                        $hasLimit = false;
                        break;
                    }
                }
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    $hasLimit,
                    "Expected {$class}->slice() with limit to return a subset of the same values"
                );
            }
        }
    }
    
    
    /**
    * Ensure ReadOnlySequence->slice() errors on an offset too small
    */
    public function testSliceErrorsOnSmallOffset()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ($sequences as $sequence) {
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
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() with offset too large returns no values
     */
    public function testSliceWithLargeOffsetReturnsNoValues()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ($sequences as $sequence) {
                $class = self::getClassName( $sequence );
                $slice = $sequence->slice( $sequence->getLastKey() + 1 );
                $this->assertEquals(
                    0,
                    $slice->count(),
                    "Expected {$class}->slice() given an offset too large returns an empty object"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->slice() errors on a negative offset
     */
    public function testSliceErrorsOnNegativeLimits()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ($sequences as $sequence) {
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
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->split()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->split() returns same type
     */
    public function testSplitReturnsSameType()
    {
        $typedValues = CollectionTestData::Get();
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            $value = $typedValues[ $type ][ 0 ];
            foreach ( $sequences as $sequence ) {
                $split = $sequence->split( $value );
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    get_class( $sequence ) === get_class( $split ),
                    "Expected {$class}->split() to return the same type"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->split() returns same inner sequence type
     */
    public function testSplitReturnsSameInnerType()
    {
        $typedValues = CollectionTestData::Get();
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            $value = $typedValues[ $type ][ 0 ];
            foreach ( $sequences as $sequence ) {
                $split = $sequence->split( $value );
                if ( $split->count() === 0 ) {
                    continue;
                }
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    get_class( $sequence ) === get_class( $split->get( $split->getFirstKey() )),
                    "Expected {$class}->split() to return the same inner type"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->split() returns all sequence values stored in
     * the proper location on the returned split sequence
     */
    public function testSplitReturnsValidInnerSequenceData()
    {
        foreach ( ReadOnlySequenceData::GetDuplicates() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                for (
                    $key = $sequence->getFirstKey();
                    $key <= ( $sequence->count() / 2 );
                    $key++
                ) {
                    
                    // Variables
                    $class     = self::getClassName( $sequence );
                    $value     = $sequence->get( $key );
                    $split     = $sequence->split( $value );
                    $outerKey  = 0;
                    $innerKey  = 0;
                    
                    // Ensure each sequence value is in the proper location
                    // in the split sequence
                    foreach ( $sequence as $sequenceKey => $sequenceValue ) {
                        if ( $sequenceValue !== $value ) {
                            $this->assertEquals(
                                $sequenceValue,
                                $split->get( $outerKey )->get( $innerKey ),
                                "{$class}->split() does not have the sequence value at the expected key"
                            );
                            $innerKey++;
                        }
                        
                        // Values are equal and tests have been run on the inner
                        else if ( 0 !== $innerKey ) {
                            $outerKey++;
                            $innerKey = 0;
                        }
                    }
                }
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->split() return one inner sequence on unfound delimiter
     */
    public function testSplitReturnsOneInnerSequenceOnUnfoundDelimiter()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                if ( 0 === $sequence->count() ) {
                    continue;
                }
                $split = $sequence->split( 'foobar' );
                $class = self::getClassName( $sequence );
                $this->assertEquals(
                    1,
                    $split->count(),
                    "Expected {$class}->split() to return one inner sequence on unfound delimiter"
                );
            }
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->split() returns same inner sequence count when
     * the delimiter is not found
     */
    public function testSplitHasSameInnerCountOnUnfoundDelimiter()
    {
        foreach ( ReadOnlySequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                if ( 0 === $sequence->count() ) {
                    continue;
                }
                $split = $sequence->split( 'foobar' );
                $class = self::getClassName( $sequence );
                $this->assertEquals(
                    $sequence->count(),
                    $split->get( $split->getFirstKey() )->count(),
                    "Expected {$class}->split() to return the same inner sequence count on an unfound delimiter"
                );
            }
        }
    }
}
