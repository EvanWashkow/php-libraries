<?php

namespace PHP\Tests\Collections\Types;

use PHP\Collections\Collection\AnonymousKeyType;
use PHP\Types\TypeLookupSingleton;

/**
 * Tests AnonymousKeyType
 */
class AnonymousKeyTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Ensure is() returns false for null
     **/
    public function testIsReturnsFalseForNull()
    {
        $this->assertFalse(
            ( new AnonymousKeyType() )->is('null'),
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
        $this->assertEquals(
            $expected,
            (new AnonymousKeyType())->isValueOfType($value),
            'AnonymousKeyType->isValueOfType() did not return the expected value.'
        );
    }

    public function getIsValueOfTypeTestData(): array
    {
        return [
            '1'    => [1,    true],
            '1.5'  => [1.5,  true],
            'null' => [null, false]
        ];
    }
}
