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
     * Ensure Sequence->add() has a higher count
     */
    public function testAddHasHigherCount()
    {
        foreach ( SequenceData::Get() as $sequence ) {
            if ( 0 === $sequence->count() ) {
                continue;
            }
            $before = $sequence->count();
            $sequence->add( $sequence->get( $sequence->getLastKey() ));
            $class = self::getClassName( $sequence );
            $this->assertGreaterThan(
                $before,
                $sequence->count(),
                "Expected {$class}->add() to have a higher count"
            );
        }
    }
    
    
    /**
     * Ensure Sequence->add() has a higher count
     */
    public function testAddErrorsOnWrongType()
    {
        foreach ( SequenceData::GetTyped() as $sequence ) {
            if ( 0 === $sequence->count() ) {
                continue;
            }
            $isError = false;
            try {
                $sequence->add( $sequence->getFirstKey() );
            }
            catch ( \Exception $e ) {
                $isError = true;
            }
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $isError,
                "Expected {$class}->add() to error on the wrong type"
            );
        }
    }
    
    
    /**
     * Ensure Sequence->add() has the same value at the end
     */
    public function testAddValueIsSame()
    {
        foreach ( SequenceData::Get() as $sequence ) {
            if ( 0 === $sequence->count() ) {
                continue;
            }
            $value = $sequence->get( $sequence->getLastKey() );
            $sequence->add( $value );
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $value === $sequence->get( $sequence->getLastKey() ),
                $sequence->count(),
                "Expected {$class}->add() to have the same value at the end"
            );
        }
    }
    
    
    /**
     * Ensure Sequence->add() has same value on empty
     */
    public function testAddValueIsSameOnEmpty()
    {
        foreach ( SequenceData::Get() as $sequence ) {
            if ( 0 === $sequence->count() ) {
                continue;
            }
            $value = $sequence->get( $sequence->getLastKey() );
            $sequence->clear();
            $sequence->add( $value );
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $value === $sequence->get( $sequence->getLastKey() ),
                $sequence->count(),
                "Expected {$class}->add() to have the same value on empty"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                            Sequence->insert()
    ***************************************************************************/
    
    
    /**
     * Ensure Sequence->insert() has entries
     */
    public function testInsertHasEntries()
    {
        foreach ( self::GetInstances() as $type => $sequence ) {
            $values = CollectionTestData::Get()[ $type ];
            $sequence->insert( 0, $values[0] );
            $sequence->insert( 1, $values[1] );
            $class = self::getClassName( $sequence );
            $this->assertEquals(
                2,
                $sequence->count(),
                "Expected {$class}->insert() to have entries"
            );
        }
    }
    
    
    /**
     * Ensure Sequence->insert() errors on key too small
     */
    public function testInsertErrorsOnKeyTooSmall()
    {
        foreach ( self::GetInstances() as $type => $sequence ) {
            $isError = false;
            try {
                $sequence->insert( $sequence->getFirstKey() - 1, $values[0] );
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
    
    
    
    
    /***************************************************************************
    *                                  DATA
    ***************************************************************************/
    
    
    /**
     * Retrieve test instances
     *
     * @return array
     */
    final public static function GetInstances(): array
    {
        $instances = [];
        foreach ( CollectionTestData::Get() as $type => $values ) {
            $instances[ $type ] = new Sequence( $type );
        }
        return $instances;
    }
}
