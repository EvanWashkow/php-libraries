<?php
namespace PHP\Tests\Collections\Types;

require_once( __DIR__ . '/WildcardTypeTest.php' );

use PHP\Collections\Collection\WildcardKeyType;

/**
 * Tests WildcardKeyType
 */
class WildcardKeyTypeTest extends WildcardTypeTest
{


    /**
     * Ensure equals() returns false for null
     **/
    public function testEqualsReturnsFalseForNull()
    {
        $this->assertFalse(
            ( new WildcardKeyType() )->equals( null ),
            'WildcardKeyType->equals() should return false for a null value'
        );
    }


    /**
     * Ensure equals() returns false for null type
     **/
    public function testEqualsReturnsFalseForNullType()
    {
        $nullType = \PHP\Types::GetByValue( null );
        $this->assertFalse(
            ( new WildcardKeyType() )->equals( $nullType ),
            'WildcardKeyType->equals() should return false for a null type'
        );
    }


    /**
     * Ensure is() returns false for null
     **/
    public function testIsReturnsFalseForNull()
    {
        $this->assertFalse(
            ( new WildcardKeyType() )->is( 'null' ),
            'WildcardKeyType->is() should return false for "null"'
        );
    }
}
