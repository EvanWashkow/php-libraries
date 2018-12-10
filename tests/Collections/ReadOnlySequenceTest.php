<?php
namespace PHP\Tests;

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/ReadOnlySequenceData.php' );

/**
 * Test all ReadOnlySequence methods to ensure consistent functionality
 *
 * This tests both the read-only and the editable sequnce (the read-only
 * simply invokes the editable)
 */
class ReadOnlySequenceTest extends CollectionsTestCase
{
    
    
    
    
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
        $typedValues = CollectionsTestData::Get();
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
        $typedValues = CollectionsTestData::Get();
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
     * Ensure ReadOnlySequence->split() returns the requested limit (of 1)
     */
    public function testSplitReturnsLimit()
    {
        foreach ( ReadOnlySequenceData::GetDuplicates() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                for (
                    $key = $sequence->getFirstKey();
                    $key <= ( $sequence->count() / 2 );
                    $key++
                ) {
                    $value = $sequence->get( $key );
                    $split = $sequence->split( $value, 1 );
                    $class = self::getClassName( $sequence );
                    $this->assertLessThanOrEqual(
                        1,
                        $split->count(),
                        "Expected {$class}->split() to return the requested limit of 1"
                    );
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
