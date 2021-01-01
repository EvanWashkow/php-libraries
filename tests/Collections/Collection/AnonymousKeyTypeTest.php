<?php
namespace PHP\Tests\Collections\Types;

use PHP\Collections\Collection\AnonymousKeyType;
use PHP\Types\Models\AnonymousType;
use PHP\Types\TypeLookupSingleton;

/**
 * Tests AnonymousKeyType
 */
class AnonymousKeyTypeTest extends \PHPUnit\Framework\TestCase
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
        $nullType = TypeLookupSingleton::getInstance()->getByValue( null );
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


    /**
     * Tests isValueOfType()
     *
     * @dataProvider getIsValueOfTypeTestData
     *
     * @param $value
     * @param bool $expected
     */
    public function testIsValueOfType($value, bool $expected): void
    {
        $this->assertEquals(,
            $expected,
            (new AnonymousType())->isValueOfType($value),
            'AnonymousKeyType->isValueOfType() did not return the expected value.'
        );
    }

    public function getIsValueOfTypeTestData(): array
    {
        return [
            '1' =>    [1, true],
            'null' => [null, false]
        ];
    }
}
