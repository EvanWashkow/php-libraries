<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\Collections\Sequence;

require_once( __DIR__ . '/SequenceData.php' );
require_once( __DIR__ . '/CollectionsTestCase.php' );

/**
 * Test all Sequence methods to ensure consistent functionality
 */
class SequenceTest extends CollectionsTestCase
{
    
    /***************************************************************************
    *                            Sequence->add()
    ***************************************************************************/
    
    
    /**
     * Ensure Sequence->add() has the same value at the end
     */
    public function testAddValueIsSame()
    {
        foreach ( SequenceData::Get() as $type => $sequences ) {
            $value = CollectionsTestData::Get()[ $type ][ 0 ];
            foreach ( $sequences as $sequence ) {
                $before = $sequence->count();
                $class  = self::getClassName( $sequence );
                $sequence->add( $value );
                $this->assertEquals(
                    $value,
                    $sequence->get( $sequence->getLastKey() ),
                    "Expected {$class}->add() to have the same value at the end"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->add() errors on the wrong value type
     */
    public function testAddErrorsOnWrongType()
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
                        $sequence->add( $values[ 0 ] );
                    } catch (\Exception $e) {
                        $isError = true;
                    }
                    $class = self::getClassName( $sequence );
                    $this->assertTrue(
                        $isError,
                        "Expected {$class}->insert() to error on wrong value type"
                    );
                }
            }
        }
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
            (new Sequence())->getFirstKey(),
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
     * @dataProvider getGetKeyOfData
     *
     * @param Sequence $sequence        The sequence
     * @param mixed    $value           The value to get the key of
     * @param int      $offset          The offset to start the search from
     * @param bool     $isReverseSearch Start from the end of the sequence?
     * @param mixed    $expected        The expected key
     **/
    public function testGetKeyOf( Sequence $sequence,
                                           $value,
                                  int      $offset,
                                  bool     $isReverseSearch,
                                           $expected )
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
    public function getGetKeyOfData(): array
    {
        $sequence = new Sequence();
        $sequence->add( 0 );    // Index 0, Reverse Index 5
        $sequence->add( 1 );    // Index 1, Reverse Index 4
        $sequence->add( 1 );    // Index 2, Reverse Index 3
        $sequence->add( 0 );    // Index 3, Reverse Index 2
        $sequence->add( 0 );    // Index 4, Reverse Index 1
        $sequence->add( 1 );    // Index 5, Reverse Index 0

        return [
            
            // Non-reverse search
            'Value 1, Offset 0, Reverse false' => [ $sequence, 1, 0, false, 1 ],
            'Value 1, Offset 2, Reverse false' => [ $sequence, 1, 2, false, 2 ],
            'Value 0, Offset 1, Reverse false' => [ $sequence, 0, 1, false, 3 ],
            
            // Reverse search
            'Value 1, Offset 0, Reverse true'  => [ $sequence, 1, 0, true,  5 ],
            'Value 0, Offset 0, Reverse true'  => [ $sequence, 0, 0, true,  4 ],
            'Value 0, Offset 2, Reverse true'  => [ $sequence, 0, 2, true,  3 ],
            'Value 1, Offset 1, Reverse true'  => [ $sequence, 1, 1, true,  2 ],

            // Unfound value
            'Non-empty sequence unfound value: offset, no reverse' => [
                $sequence, 0, 5, false, NULL
            ],
            'Non-empty sequence unfound value: offset, reverse' => [
                $sequence, 1, 5, true, NULL
            ]
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
                $class = self::getClassName( $sequence );
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
                $class = self::getClassName( $sequence );
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
                $class         = self::getClassName( $sequence );
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
                $class = self::getClassName( $sequence );
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
                $class = self::getClassName( $sequence );
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
                $class = self::getClassName( $sequence );
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
                    $class = self::getClassName( $sequence );
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
            ( new Sequence() )->reverse(),
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
            ( new Sequence() )->slice( 0 ),
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
        $sequence = new Sequence();
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
            ( new Sequence() )->slice( -1 );
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
            ( new Sequence() )->slice( 0, -1 );
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
            ( new Sequence() )->split( '1' ),
            'Sequence->split() should return a new Sequence instance'
        );
    }


    /**
     * Ensure Sequence->split() returns an inner Sequence
     **/
    public function testSplitInnerReturnType()
    {
        $sequence = new Sequence();
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
     *
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
        $sequence = new Sequence();
        $sequence->add( 0 );
        $sequence->add( 1 );
        $sequence->add( 1 );
        $sequence->add( 0 );
        $sequence->add( 1 );
        $sequence->add( 0 );


        return [
            'Delimiter 0, Limit max' => [
                $sequence, 0, PHP_INT_MAX, [ [ 1, 1 ], [ 1 ] ]
            ],
            'Delimiter 1, Limit max' => [
                $sequence, 1, PHP_INT_MAX, [ [ 0 ], [ 0 ], [ 0 ] ]
            ],
            'Delimiter 1, Limit 0' => [
                $sequence, 1, 0, []
            ],
            'Delimiter 1, Limit 2' => [
                $sequence, 1, 2, [ [ 0 ], [ 0 ] ]
            ],
            'Unfound delimiter' => [
                $sequence, 5, PHP_INT_MAX, [ [ 0, 1, 1, 0, 1, 0 ] ]
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
        $data[ 'Empty Sequence' ] = [ new Sequence() ];

        // Sequence with one entry
        $sequence = new Sequence();
        $sequence->add(0);
        $data[ 'Sequence with one entry' ] = [ $sequence ];

        // Sequence with multiple entries
        $sequence = new Sequence();
        $sequence->add(0);
        $sequence->add(1);
        $sequence->add(2);
        $data[ 'Sequence with multiple entries' ] = [ $sequence ];

        return $data;
    }
}
