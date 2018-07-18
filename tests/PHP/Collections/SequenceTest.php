<?php

use PHP\Collections\Sequence;

require_once( __DIR__ . '/SequenceData.php' );
require_once( __DIR__ . '/CollectionTestCase.php' );
require_once( __DIR__ . '/CollectionTestData.php' );

/**
 * Test all Sequence methods to ensure consistent functionality
 */
class SequenceTest extends CollectionTestCase
{
    
    /***************************************************************************
    *                            Sequence->add()
    ***************************************************************************/
    
    
    /**
     * Ensure Sequence->add() has the same value at the end
     */
    public function testAddValueIsSame()
    {
        foreach ( self::GetInstances() as $type => $sequences ) {
            $value = CollectionTestData::Get()[ $type ][ 0 ];
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
        foreach ( self::GetInstances() as $type => $sequences ) {
            if ( '' === $type ) {
                continue;
            }
            
            foreach ( $sequences as $sequence ) {
                foreach ( CollectionTestData::Get() as $valueType => $values ) {
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
    *                            Sequence->insert()
    ***************************************************************************/
    
    
    /**
     * Ensure Sequence->insert() has the inserted value at the beginning of the
     * sequence
     */
    public function testInsertAtBeginning()
    {
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
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
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
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
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
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
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
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
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
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
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
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
        foreach ( self::GetInstances() as $type => $sequences ) {
            if ( '' === $type ) {
                continue;
            }
            
            foreach ( $sequences as $sequence ) {
                foreach ( CollectionTestData::Get() as $valueType => $values ) {
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
    *                                  DATA
    ***************************************************************************/
    
    
    /**
     * Retrieve test instances, indexed by type
     *
     * @return array
     */
    final public static function GetInstances(): array
    {
        $instances = [];
        foreach ( CollectionTestData::Get() as $type => $values ) {
            $sequence = new Sequence( $type );
            foreach ( $values as $value ) {
                $sequence->add( $value );
            }
            
            $instances[ $type ]   = [];
            $instances[ $type ][] = new Sequence( $type );
            $instances[ $type ][] = $sequence;
        }
        return $instances;
    }
}
