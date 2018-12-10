<?php
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
    *                               Sequence->get()
    ***************************************************************************/


    /**
     * Ensure Sequence->get() throws exception on wrong key type
     * 
     * @expectedException \InvalidArgumentException
     **/
    public function testGetThrowsErrorOnWrongKeyType()
    {
        $dictionary = new Sequence( 'integer' );
        $dictionary->add( 1 );
        $dictionary->get( 1 );
    }




    /***************************************************************************
    *                            Sequence->getFirstKey()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->getFirstKey() returns zero
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
    *                      ReadOnlySequence->getKeyOf()
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
     * @param int      $expected        The expected key
     **/
    public function testGetKeyOf( Sequence $sequence,
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
            'Value 0, Offset 0, Reverse false' => [ $sequence, 0, 0, false, 0 ],
            'Value 1, Offset 0, Reverse false' => [ $sequence, 1, 0, false, 1 ],
            'Value 1, Offset 2, Reverse false' => [ $sequence, 1, 2, false, 2 ],
            'Value 0, Offset 1, Reverse false' => [ $sequence, 0, 1, false, 3 ],

            // Reverse search
            'Value 1, Offset 0, Reverse true'  => [ $sequence, 1, 0, true,  5 ],
            'Value 0, Offset 0, Reverse true'  => [ $sequence, 0, 0, true,  4 ],
            'Value 0, Offset 2, Reverse true'  => [ $sequence, 0, 2, true,  3 ],
            'Value 1, Offset 1, Reverse true'  => [ $sequence, 1, 1, true,  2 ],
        ];
    }




    /***************************************************************************
    *                            Sequence->getLastKey()
    ***************************************************************************/
    
    
    /**
     * Ensure ReadOnlySequence->getLastKey() returns one less than count
     * 
     * @dataProvider getLastKeyData
     */
    public function testGetLastKey( Sequence $sequence )
    {
        $this->assertEquals(
            $sequence->getLastKey(),
            $sequence->count() - 1,
            'Sequence->getLastKey() should always return one less than the count'
        );
    }


    /**
     * Retrieve test data for testing getLastKey()
     *
     * @return array
     **/
    public function getLastKeyData(): array
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
    
    
    
    
    /***************************************************************************
    *                            Sequence->hasValue()
    ***************************************************************************/


    /**
     * Ensure Sequence->hasValue() returns true for the value
     **/
    public function testHasValueReturnsTrueForValue()
    {
        $sequence = new Sequence( 'integer' );
        $sequence->add( 1 );
        $this->assertTrue(
            $sequence->hasValue( 1 ),
            'Sequence->hasValue() should return true for the value'
        );
    }


    /**
     * Ensure Sequence->hasValue() returns false for wrong value
     **/
    public function testHasValueReturnsFalseForWrongValue()
    {
        $sequence = new Sequence( 'integer' );
        $sequence->add( 1 );
        $this->assertFalse(
            $sequence->hasValue( 2 ),
            'Sequence->hasValue() should return false for wrong value'
        );
    }


    /**
     * Ensure Sequence->hasValue() returns false for wrong value type
     **/
    public function testHasValueReturnsFalseForWrongValueType()
    {
        $sequence = new Sequence( 'integer' );
        $sequence->add( 1 );
        $this->assertFalse(
            $sequence->hasValue( '1' ),
            'Sequence->hasValue() should return false for wrong value type'
        );
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
    *                             Sequence->toArray()
    ***************************************************************************/
    
    /**
     * Ensure Sequence->toArray() returns the array
     * 
     * @dataProvider getToArrayData
     * 
     * @param Sequence $sequence The sequence to convert to array
     * @param array    $array    The expected array
     */
    public function testToArray( Sequence $sequence, array $array )
    {
        $this->assertEquals(
            $sequence->toArray(),
            $array,
            'Sequence->toArray() did not return the expected array'
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
        $data[ 'Empty Sequence' ] = [
            new Sequence(),
            []
        ];

        // Sequence with two entries
        $sequence = new Sequence();
        $sequence->add( 0 );
        $sequence->add( 1 );
        $data[ 'Sequence with two entries' ] = [
            $sequence,
            [
                0 => 0,
                1 => 1
            ]
        ];

        return $data;
    }
}
