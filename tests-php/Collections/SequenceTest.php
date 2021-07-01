<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\Byte;
use PHP\Collections\ByteArray;
use PHP\Collections\Sequence;
use PHP\Tests\Collections\CollectionTestDefinition;

require_once( __DIR__ . '/SequenceData.php' );

/**
 * Test all Sequence methods to ensure consistent functionality
 */
final class SequenceTest extends CollectionTestDefinition
{


    public function getSerializationTestData(): array
    {
        return [
            'Sequence(int)' => [
                new Sequence('int', [1, 2, 3]),
            ],
            'Sequence(string)' => [
                new Sequence('string', ['one', 'two', 'three']),
            ],
            'Sequence(Byte)' => [
                new Sequence(
                    Byte::class,
                    [
                        new Byte(1),
                        new Byte(2),
                        new Byte(3)
                    ]
                ),
            ],
            'Sequence(ByteArray)' => [
                new Sequence(
                    ByteArray::class,
                    [
                        new ByteArray(1),
                        new ByteArray(2),
                        new ByteArray(3)
                    ]
                ),
            ],
        ];
    }




    /***************************************************************************
    *                            Sequence->add()
    ***************************************************************************/

    /**
     * Ensure Sequence->add() returns the correct results
     * 
     * @dataProvider getAddData
     * 
     * @param Sequence $sequence        The sequence to test
     * @param array    $newValues       The values to add to the sequence
     * @param array    $expectedValues  The expected values from toArray()
     * @param bool     $isErrorExpected If an error should be thrown
     */
    public function testAdd( Sequence $sequence,
                             array    $newValues,
                             array    $expectedValues,
                             bool     $isErrorExpected )
    {
        // Tests
        $isError = false;
        try {
            foreach ( $newValues as $value ) {
                $sequence->add( $value );
            }
        } catch ( \Throwable $th ) {
            $isError = true;
        }

        // Assert same values
        $this->assertEquals(
            $expectedValues,
            $sequence->toArray(),
            'Sequence->add() did not add the values properly'
        );

        // Assert error
        $postMessage = $isErrorExpected
            ? 'did not throw an error, as expected'
            : 'threw an error, which was not expected';
        $this->assertEquals(
            $isErrorExpected,
            $isError,
            "Sequence->add() {$postMessage}"
        );
    }


    public function getAddData(): array
    {
        return [

            // Non-errors
            'Empty Sequence, adding no values' => [
                new Sequence( 'string' ),
                [],
                [],
                false
            ],
            'Empty Sequence, adding right value types' => [
                new Sequence( 'string' ),
                [ 'foo', 'bar' ],
                [ 'foo', 'bar' ],
                false
            ],
            'Non-empty Sequence, adding right value types' => [
                new Sequence( 'string', [ 'foo', 'bar' ] ),
                [ 'biz', 'baz' ],
                [ 'foo', 'bar', 'biz', 'baz' ],
                false
            ],

            // Errors
            'Empty Sequence, adding wrong value types' => [
                new Sequence( 'string' ),
                [ 1, 2 ],
                [],
                true
            ],
            'Non-empty Sequence, adding wrong value types' => [
                new Sequence( 'string', [ 'foo', 'bar' ] ),
                [ 1, 2 ],
                [ 'foo', 'bar' ],
                true
            ]
        ];
    }




    /***************************************************************************
    *                            Sequence->getFirstKey()
    ***************************************************************************/
    
    /**
     * Ensure       Sequence->getFirstKey() returns zero
     */
    public function testGetFirstKeyReturnsZero()
    {
        $this->assertEquals(
            (new Sequence( '*' ))->getFirstKey(),
            0,
            'The first key of a Sequence should always be zero'
        );
    }




    /***************************************************************************
    *                            Sequence->getLastKey()
    ***************************************************************************/
    
    
    /**
     * Ensure       Sequence->getLastKey() returns one less than count
     * 
     * @dataProvider getSequenceData
     */
    public function testGetLastKey( Sequence $sequence )
    {
        $this->assertEquals(
            $sequence->getLastKey(),
            $sequence->count() - 1,
            'Sequence->getLastKey() should always return one less than the count'
        );
    }




    /***************************************************************************
    *                            Sequence->getKeyOf()
    ***************************************************************************/


    /**
     * Test getKeyOf() return values
     * 
     * @dataProvider getGetKeyOfExceptionData
     *
     * @param Sequence $sequence        The sequence
     * @param mixed    $value           The value to get the key of
     * @param int      $offset          The offset to start the search from
     * @param bool     $isReverseSearch Start from the end of the sequence?
     **/
    public function testGetKeyOfException(
        Sequence $sequence,
        $value,
        int $offset,
        bool $isReverseSearch
    ) {
        $this->expectException(\Exception::class);
        $sequence->getKeyOf( $value, $offset, $isReverseSearch );
    }


    /**
     * Retrieve test data for the getKeyOf() test
     * 
     * See CollectionTest->testKeyOf() for more tests
     *
     * @return array
     **/
    public function getGetKeyOfExceptionData(): array
    {
        $sequence = new Sequence( '*' );
        $sequence->add( 0 );    // Offset 0
        $sequence->add( 1 );    // Offset 1
        $sequence->add( 1 );    // Offset 2
        $sequence->add( 0 );    // Offset 3
        $sequence->add( 0 );    // Offset 4
        $sequence->add( 1 );    // Offset 5

        return [
            'Non-empty sequence with offset too small' => [
                $sequence, 0, -1, false
            ],
            'Non-empty sequence with offset too large' => [
                $sequence, 0, 10, false
            ],
            'Non-empty sequence unfound value: Offset 5, Reverse false' => [
                $sequence, 0, 5, false
            ],
            'Non-empty sequence unfound value: Offset 0, Reverse true' => [
                $sequence, 1, 0, true
            ]
        ];
    }


    /**
     * Test getKeyOf() return values
     * 
     * @dataProvider getGetKeyOfResultData
     *
     * @param Sequence $sequence        The sequence
     * @param mixed    $value           The value to get the key of
     * @param int      $offset          The offset to start the search from
     * @param bool     $isReverseSearch Start from the end of the sequence?
     * @param int      $expected        The expected key
     **/
    public function testGetKeyOfResult( Sequence $sequence,
                                                 $value,
                                        int      $offset,
                                        bool     $isReverseSearch,
                                        int      $expected )
    {
        $this->assertEquals(
            $sequence->getKeyOf( $value, $offset, $isReverseSearch ),
            $expected
        );
    }


    /**
     * Retrieve test data for the getKeyOf() test
     * 
     * See CollectionTest->testKeyOf() for more tests
     *
     * @return array
     **/
    public function getGetKeyOfResultData(): array
    {
        $sequence = new Sequence( '*' );
        $sequence->add( 0 );    // Offset 0
        $sequence->add( 1 );    // Offset 1
        $sequence->add( 1 );    // Offset 2
        $sequence->add( 0 );    // Offset 3
        $sequence->add( 0 );    // Offset 4
        $sequence->add( 1 );    // Offset 5

        return [
            
            // Non-reverse search
            'Value 1, Offset 0, Reverse false' => [ $sequence, 1, 0, false, 1 ],
            'Value 1, Offset 2, Reverse false' => [ $sequence, 1, 2, false, 2 ],
            'Value 0, Offset 1, Reverse false' => [ $sequence, 0, 1, false, 3 ],
            
            // Reverse search
            'Value 1, Offset 5, Reverse true'  => [ $sequence, 1, 5, true,  5 ],
            'Value 0, Offset 5, Reverse true'  => [ $sequence, 0, 5, true,  4 ],
            'Value 0, Offset 3, Reverse true'  => [ $sequence, 0, 3, true,  3 ],
            'Value 1, Offset 4, Reverse true'  => [ $sequence, 1, 4, true,  2 ]
        ];
    }
    
    
    
    
    /***************************************************************************
    *                            Sequence->insert()
    ***************************************************************************/
    
    
    /**
     * Ensure Sequence->insert() has the inserted value at the beginning of the
     * sequence
     */
    public function testInsertAtBeginning()
    {
        $values = CollectionsTestData::Get();
        foreach ( SequenceData::Get() as $type => $sequences ) {
            $value = $values[ $type ][ 0 ];
            foreach ( $sequences as $sequence ) {
                $key   = $sequence->getFirstKey();
                $class = get_class( $sequence );
                $sequence->insert( $key, $value );
                $this->assertEquals(
                    $value,
                    $sequence->get( $key ),
                    "Expected {$class}->insert() to have the inserted value at the beginning of the sequence"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() has the inserted value at the end of the
     * sequence
     */
    public function testInsertAtEnd()
    {
        $values = CollectionsTestData::Get();
        foreach ( SequenceData::Get() as $type => $sequences ) {
            $value = $values[ $type ][ 0 ];
            foreach ( $sequences as $sequence ) {
                $key   = $sequence->getLastKey() + 1;
                $class = get_class( $sequence );
                $sequence->insert( $key, $value );
                $this->assertEquals(
                    $value,
                    $sequence->get( $key ),
                    "Expected {$class}->insert() to have the inserted value at the end of the sequence"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() shifts values
     */
    public function testInsertShiftsValues()
    {
        $values = CollectionsTestData::Get();
        foreach ( SequenceData::Get() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                if ( 0 === $sequence->count() ) {
                    continue;
                }
                $value         = $values[ $type ][ 0 ];
                $key           = $sequence->getFirstKey();
                $previousValue = $sequence->get( $key );
                $class         = get_class( $sequence );
                $sequence->insert( $key, $value );
                $this->assertEquals(
                    $previousValue,
                    $sequence->get( $key + 1 ),
                    "Expected {$class}->insert() shifts values"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() errors on key too small
     */
    public function testInsertErrorsOnKeyTooSmall()
    {
        $values = CollectionsTestData::Get();
        foreach ( SequenceData::Get() as $type => $sequences ) {
            $typeValues = $values[ $type ];
            foreach ( $sequences as $sequence ) {
                $isError = false;
                try {
                    $sequence->insert( $sequence->getFirstKey() - 1, $typeValues[0] );
                } catch (\Exception $e) {
                    $isError = true;
                }
                $class = get_class( $sequence );
                $this->assertTrue(
                    $isError,
                    "Expected {$class}->insert() to error on key too small"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() errors on key too large
     */
    public function testInsertErrorsOnKeyTooLarge()
    {
        $values = CollectionsTestData::Get();
        foreach ( SequenceData::Get() as $type => $sequences ) {
            $typeValues = $values[ $type ];
            foreach ( $sequences as $sequence ) {
                $isError = false;
                try {
                    $sequence->insert( $sequence->getLastKey() + 2, $typeValues[0] );
                } catch (\Exception $e) {
                    $isError = true;
                }
                $class = get_class( $sequence );
                $this->assertTrue(
                    $isError,
                    "Expected {$class}->insert() to error on key too large"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() errors on wrong key type
     */
    public function testInsertErrorsOnWrongKeyType()
    {
        $values = CollectionsTestData::Get();
        foreach ( SequenceData::Get() as $type => $sequences ) {
            $value = $values[ $type ][0];
            foreach ( $sequences as $sequence ) {
                $isError = false;
                try {
                    $sequence->insert( 'string', $value );
                } catch (\TypeError $e) {
                    $isError = true;
                }
                $class = get_class( $sequence );
                $this->assertTrue(
                    $isError,
                    "Expected {$class}->insert() to error on wrong key type"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() errors on wrong value type
     */
    public function testInsertErrorsOnWrongValueType()
    {
        foreach ( SequenceData::Get() as $type => $sequences ) {
            if ( '' === $type ) {
                continue;
            }
            
            foreach ( $sequences as $sequence ) {
                foreach ( CollectionsTestData::Get() as $valueType => $values ) {
                    if ( in_array( $valueType, [ '', $type ] )) {
                        continue;
                    }
                    
                    $isError = false;
                    try {
                        $sequence->insert( $sequence->getFirstKey(), $values[ 0 ] );
                    } catch (\Exception $e) {
                        $isError = true;
                    }
                    $class = get_class( $sequence );
                    $this->assertTrue(
                        $isError,
                        "Expected {$class}->insert() to error on wrong value type"
                    );
                }
            }
        }
    }




    /***************************************************************************
    *                             Sequence->reverse()
    ***************************************************************************/


    /**
     * Ensure Sequence->reverse() returns a Sequence
     **/
    public function testReverseReturnType()
    {
        $this->assertInstanceOf(
            Sequence::class,
            ( new Sequence( '*' ) )->reverse(),
            'Sequence->reverse() should return a new Sequence instance'
        );
    }


    /**
     * Ensure Sequence->reverse() has the keys in reverse
     * 
     * @dataProvider getSequenceData
     * 
     * @param Sequence $sequence Original sequence
     **/
    public function testReverse( Sequence $sequence )
    {
        $reversedArray = array_reverse( $sequence->toArray() );
        $this->assertEquals(
            $reversedArray,
            $sequence->reverse()->toArray(),
            'Sequence->reverse() should reverse the entries\' order'
        );
    }




    /***************************************************************************
    *                              Sequence->slice()
    ***************************************************************************/


    /**
     * Ensure Sequence->slice() returns a Sequence
     **/
    public function testSliceReturnType()
    {
        $this->assertInstanceOf(
            Sequence::class,
            ( new Sequence( '*' ) )->slice( 0 ),
            'Sequence->slice() should return a new Sequence instance'
        );
    }


    /**
     * Ensure Sequence->slice() returns the correct values
     * 
     * @dataProvider getTestSliceResultsData
     * 
     * @param Sequence $sequence The sequence
     * @param int      $offset   Where to start the split
     * @param int      $count    Number of entries to return
     * @param array    $expected The expected result
     **/
    public function testSliceResults( Sequence $sequence,
                                      int      $offset,
                                      int      $count,
                                      array    $expected )
    {
        $this->assertEquals(
            $expected,
            $sequence->slice( $offset, $count )->toArray(),
            'Sequence->slice() did not return the correct results'
        );
    }


    /**
     * Retrieve test slice results data
     *
     * @return array
     **/
    public function getTestSliceResultsData(): array
    {
        $sequence = new Sequence( '*' );
        $sequence->add(1);
        $sequence->add(2);
        $sequence->add(3);
        $sequence->add(4);
        $sequence->add(5);

        return [
            'Offset 0, Count max' => [
                $sequence, 0, PHP_INT_MAX, [ 1, 2, 3, 4, 5 ]
            ],
            'Offset 1, Count max' => [
                $sequence, 1, PHP_INT_MAX, [ 2, 3, 4, 5 ]
            ],
            'Offset 0, Count 0' => [
                $sequence, 0, 0, []
            ],
            'Offset 0, Count 1' => [
                $sequence, 0, 1, [ 1 ]
            ],
            'Offset 0, Count 3' => [
                $sequence, 0, 3, [ 1, 2, 3 ]
            ],
            'Offset 1, Count 3' => [
                $sequence, 1, 3, [ 2, 3, 4 ]
            ],
        ];
    }


    /**
     * Ensure Sequence->slice() errors on negative offset
     **/
    public function testSliceOffetError()
    {
        try {
            ( new Sequence( '*' ) )->slice( -1 );
        } catch (\Throwable $th) {
            $isError = true;
        }

        $this->assertTrue(
            $isError,
            'Sequence->split() should throw error on negative offset'
        );
    }


    /**
     * Ensure Sequence->slice() errors on negative count
     **/
    public function testSliceCountError()
    {
        try {
            ( new Sequence( '*' ) )->slice( 0, -1 );
        } catch (\Throwable $th) {
            $isError = true;
        }

        $this->assertTrue(
            $isError,
            'Sequence->split() should throw error on negative count'
        );
    }




    /***************************************************************************
    *                              Sequence->split()
    ***************************************************************************/


    /**
     * Ensure Sequence->split() returns a Sequence
     **/
    public function testSplitReturnType()
    {
        $this->assertInstanceOf(
            Sequence::class,
            ( new Sequence( '*' ) )->split( '1' ),
            'Sequence->split() should return a new Sequence instance'
        );
    }


    /**
     * Ensure Sequence->split() returns an inner Sequence
     **/
    public function testSplitInnerReturnType()
    {
        $sequence = new Sequence( '*' );
        $sequence->add( 0 );
        $sequence->add( 1 );

        $this->assertInstanceOf(
            Sequence::class,
            $sequence->split( 1 )->get( 0 ),
            'Sequence->split() should return inner Sequence instances'
        );
    }


    /**
     * Ensure Sequence->split() returns the correct results
     * 
     * @dataProvider getSplitResultsData
     * 
     * @param Sequence $sequence  The sequence
     * @param mixed    $delimiter The dilimeter to split sequence over
     * @param int      $limit     Maximum number of entries to return
     * @param array    $expected  Expected results
     **/
    public function testSplitResults( Sequence $sequence,
                                               $delimiter,
                                      int      $limit,
                                      array    $expected )
    {
        // Variables
        $errorMessage = '';
        $isSame       = true;
        $result       = $sequence->split( $delimiter, $limit );

        // Ensure both have the same number of entry groups
        $isSame = ( $result->count() === count( $expected ) );
        if ( !$isSame ) {
            $errorMessage = 'Sequence->split() returned the wrong number of entries';
        }

        // Ensure both entry groupings are identical
        else {
            foreach ( $result as $index => $innerSequence ) {
                $isSame = ( $expected[ $index ] === $innerSequence->toArray() );
                if ( !$isSame ) {
                    $errorMessage = 'Sequence->split() returned the wrong sub-entries';
                }
            }
        }

        // Assert equality
        $this->assertTrue( $isSame, $errorMessage );
    }


    /**
     * Retrieve test data for Sequence->split()
     * 
     * @return array
     */
    public function getSplitResultsData(): array
    {
        $sequence = new Sequence( 'int', [
            0 => 0,
            1 => 1,
            2 => 1,
            3 => 0,
            4 => 1,
            5 => 0,
            6 => 0
        ]);

        return [
            'No entries' => [
                new Sequence( '*' ), 0, PHP_INT_MAX, []
            ],
            'One entry, found delimiter' => [
                new Sequence( '*', [ 1 ] ),
                1,
                PHP_INT_MAX, 
                []
            ],
            'One entry, unfound delimiter' => [
                new Sequence( '*', [ 1 ] ),
                0,
                PHP_INT_MAX,
                [ [ 1 ] ]
            ],
            'Multiple entries, Delimiter 0, Limit max' => [
                $sequence, 0, PHP_INT_MAX, [ [ 1, 1 ], [ 1 ] ]
            ],
            'Multiple entries, Delimiter 1, Limit max' => [
                $sequence, 1, PHP_INT_MAX, [ [ 0 ], [ 0 ], [ 0, 0 ] ]
            ],
            'Multiple entries, Delimiter 1, Limit 0' => [
                $sequence, 1, 0, []
            ],
            'Multiple entries, Delimiter 1, Limit 2' => [
                $sequence, 1, 2, [ [ 0 ], [ 0 ] ]
            ],
            'Multiple entries, Unfound delimiter' => [
                $sequence, 5, PHP_INT_MAX, [ [ 0, 1, 1, 0, 1, 0, 0 ] ]
            ]
        ];
    }



    
    /****************************************************************************                               SHARED DATA PROVIDERS
    ***************************************************************************/


    /**
     * Retrieve test data for sequences
     *
     * @return array
     **/
    public function getSequenceData(): array
    {
        $data = [];

        // Empty sequence
        $data[ 'Empty Sequence' ] = [ new Sequence( '*' ) ];

        // Sequence with one entry
        $sequence = new Sequence( '*' );
        $sequence->add(0);
        $data[ 'Sequence with one entry' ] = [ $sequence ];

        // Sequence with multiple entries
        $sequence = new Sequence( '*' );
        $sequence->add(0);
        $sequence->add(1);
        $sequence->add(2);
        $data[ 'Sequence with multiple entries' ] = [ $sequence ];

        return $data;
    }
}
