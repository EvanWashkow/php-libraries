<?php
namespace PHP\Tests;

/**
 * Test custom PHP functions
 */
class FunctionsTest extends \PHPUnit\Framework\TestCase
{

    /***************************************************************************
    *                                   is()
    ***************************************************************************/


    /**
     * Ensure is() returns true
     */
    public function testIsReturnsTrue()
    {
        $this->assertTrue(
            is( 1, 'int' ),
            'is() should return true when given a valid query'
        );
    }


    /**
     * Ensure is() returns false
     */
    public function testIsReturnsFalse()
    {
        $this->assertFalse(
            is( 1, 'bool' ),
            'is() should return false when given an invalid query'
        );
    }
}
