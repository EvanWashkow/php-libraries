<?php
namespace PHP\Tests\Collections\Types;

require_once( __DIR__ . '/AnonymousTypeTest.php' );

use PHP\Collections\Collection\AnonymousKeyType;

/**
 * Tests AnonymousKeyType
 */
class AnonymousKeyTypeTest extends AnonymousTypeTest
{


    /**
     * Ensure equals() returns false for null
     **/
    public function testEqualsReturnsFalseForNull()
    {
        $this->assertFalse(
            ( new AnonymousKeyType() )->equals( null ),
            'AnonymousKeyType->equals() should return false for a null value'
        );
    }


    /**
     * Ensure equals() returns false for null type
     **/
    public function testEqualsReturnsFalseForNullType()
    {
        $nullType = \PHP\Types::GetByValue( null );
        $this->assertFalse(
            ( new AnonymousKeyType() )->equals( $nullType ),
            'AnonymousKeyType->equals() should return false for a null type'
        );
    }


    /**
     * Ensure is() returns false for null
     **/
    public function testIsReturnsFalseForNull()
    {
        $this->assertFalse(
            ( new AnonymousKeyType() )->is( 'null' ),
            'AnonymousKeyType->is() should return false for "null"'
        );
    }
}
