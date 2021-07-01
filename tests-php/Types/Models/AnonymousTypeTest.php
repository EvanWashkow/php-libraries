<?php
namespace PHP\Tests\Types\Models;

use PHP\Types\Models\AnonymousType;

/**
 * Tests AnonymousType
 */
final class AnonymousTypeTest extends TypeTestDefinition
{


    public function getSerializationTestData(): array
    {
        return [
            'AnonymousType' => [ new AnonymousType() ],
        ];
    }


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
     **/
    public function testIsClass()
    {
        $this->expectException(\BadMethodCallException::class);
        ( new AnonymousType() )->isClass();
    }


    /**
     * Ensure AnonymousType->isInterface() throws an exception
     **/
    public function testIsInterface()
    {
        $this->expectException(\BadMethodCallException::class);
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
