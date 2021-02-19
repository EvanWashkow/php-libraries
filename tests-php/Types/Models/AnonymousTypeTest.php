<?php
namespace PHP\Tests\Types\Models;

use PHP\Types\Models\AnonymousType;

/**
 * Tests AnonymousType
 */
class AnonymousTypeTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Ensure AnonymousType->getName() is an asterisk
     **/
    public function testGetNameIsAsterisk()
    {
        $this->assertEquals(
            '*',
            ( new AnonymousType() )->getName(),
            'AnonymousType->getName() should return an asterisk'
        );
    }


    /**
     * Ensure AnonymousType->is() is true for anything
     **/
    public function testIsAlwaysReturnsTrue()
    {
        $typeNames = [
            'int',
            'string',
            'bool'
        ];
        $type = new AnonymousType();
        foreach ( $typeNames as $typeName ) {
            $this->assertTrue(
                $type->is( $typeName ),
                'AnonymousType->is() should always return true'
            );
        }
    }


    /**
     * Ensure AnonymousType->isClass() throws an exception
     * 
     * @expectedException \BadMethodCallException
     **/
    public function testIsClass()
    {
        ( new AnonymousType() )->isClass();
    }


    /**
     * Ensure AnonymousType->isInterface() throws an exception
     * 
     * @expectedException \BadMethodCallException
     **/
    public function testIsInterface()
    {
        ( new AnonymousType() )->isInterface();
    }


    /**
     * Tests isValueOfType()
     *
     * @dataProvider getIsValueOfTypeTestData
     *
     * @param $value
     */
    public function testIsValueOfType($value): void
    {
        $this->assertTrue(
            (new AnonymousType())->isValueOfType($value),
            'AnonymousType->isValueOfType() should always return true.'
        );
    }

    public function getIsValueOfTypeTestData(): array
    {
        return [
            '1' => [1],
            'null' => [null]
        ];
    }
}