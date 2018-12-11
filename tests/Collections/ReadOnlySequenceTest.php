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
