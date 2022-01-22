<?php

namespace PHP\Tests\Collections\Dictionary;

use PHP\Collections\Dictionary\DictionaryAnonymousKeyType;
use PHP\Types\TypeLookupSingleton;

/**
 * Tests DictionaryAnonymousKeyType
 */
class DictionaryAnonymousKeyTypeTest extends \PHPUnit\Framework\TestCase
{
    /*******************************************************************************************************************
     *                                                         is()
     ******************************************************************************************************************/


    /**
     * Ensure is() only returns true for ints and strings
     *
     * @dataProvider getIsData
     *
     * @param string $typeName The type name to test
     * @param bool   $expected The expected result
     **/
    public function testIs($value, bool $expected)
    {
        $this->assertEquals(
            $expected,
            ( new DictionaryAnonymousKeyType() )->is($value),
            'DictionaryAnonymousKeyType->is() should only returns true for ints and strings'
        );
    }


    /**
     * Get data for testing is()
     *
     * @return array
     */
    public function getIsData(): array
    {
        return [
            [ 'int',    true ],
            [ 'string', true ],
            [ 'float',  false ]
        ];
    }




    /*******************************************************************************************************************
     *                                                      isClass()
     ******************************************************************************************************************/


    /**
     * Ensure isClass() only returns false
     **/
    public function testIsClass()
    {
        $this->assertFalse(
            ( new DictionaryAnonymousKeyType() )->isClass(),
            'DictionaryAnonymousKeyType->isClass() should only return false'
        );
    }




    /*******************************************************************************************************************
     *                                                      isInterface()
     ******************************************************************************************************************/


    /**
     * Ensure isInterface() only returns false
     **/
    public function testIsInterface()
    {
        $this->assertFalse(
            ( new DictionaryAnonymousKeyType() )->isInterface(),
            'DictionaryAnonymousKeyType->isInterface() should only return false'
        );
    }




    /*******************************************************************************************************************
     *                                                      isValueOfType()
     ******************************************************************************************************************/


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
            (new DictionaryAnonymousKeyType())->isValueOfType($value),
            'AnonymousKeyType->isValueOfType() did not return the expected value.'
        );
    }

    public function getIsValueOfTypeTestData(): array
    {
        return [
            '1'        => [1,        true],
            '"string"' => ['string', true],
            '1.5'      => [1.5,      false],
            'null'     => [null,     false]
        ];
    }
}
