<?php

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/SequenceData.php' );

/**
 * Test all Sequence methods to ensure consistent functionality
 */
class SequenceTest extends \PHP\Tests\Collections\CollectionsTestCase
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
}
