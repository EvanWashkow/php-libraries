<?php

use PHP\Collections\Dictionary;

require_once( __DIR__ . '/CollectionsTestCase.php' );

/**
 * Test all Dictionary methods to ensure consistent functionality
 */
class DictionaryTest extends CollectionsTestCase
{


    /***************************************************************************
    *                            Dictionary->hasValue()
    ***************************************************************************/


    /**
     * Ensure Dictionary->hasValue() returns true for the value
     **/
    public function testHasValueReturnsTrueForValue()
    {
        $dictionary = new Dictionary( 'integer', 'integer' );
        $dictionary->set( 0, 1 );
        $this->assertTrue(
            $dictionary->hasValue( 1 ),
            'Dictionary->hasValue() should return true for the value'
        );
    }


    /**
     * Ensure Dictionary->hasValue() returns false for wrong value
     **/
    public function testHasValueReturnsFalseForWrongValue()
    {
        $dictionary = new Dictionary( 'integer', 'integer' );
        $dictionary->set( 0, 1 );
        $this->assertFalse(
            $dictionary->hasValue( 2 ),
            'Dictionary->hasValue() should return false for wrong value'
        );
    }


    /**
     * Ensure Dictionary->hasValue() returns false for wrong value type
     **/
    public function testHasValueReturnsFalseForWrongValueType()
    {
        $dictionary = new Dictionary( 'integer', 'integer' );
        $dictionary->set( 0, 1 );
        $this->assertFalse(
            $dictionary->hasValue( '1' ),
            'Dictionary->hasValue() should return false for wrong value type'
        );
    }
}