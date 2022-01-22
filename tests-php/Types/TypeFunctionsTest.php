<?php

namespace PHP\Tests;

/**
 * Test custom PHP functions.
 *
 * @internal
 * @coversNothing
 */
class TypeFunctionsTest extends \PHPUnit\Framework\TestCase
{
    // is()

    /**
     * Test is() methods.
     *
     * @dataProvider getIsData
     *
     * @param mixed  $value    The value to check
     * @param string $type     The type name to comapare the value to
     * @param bool   $expected The expected return value of is()
     */
    public function testIs($value, string $type, bool $expected)
    {
        $this->assertEquals(
            $expected,
            is($value, $type),
            'is() did not return the correct value'
        );
    }

    /**
     * Get test data for is().
     */
    public function getIsData(): array
    {
        return [
            // Basic types

            // Array
            "is( [], 'array' )" => [
                [], 'array', true,
            ],

            // Bool / boolean
            "is( true, 'bool' )" => [
                true, 'bool', true,
            ],
            "is( true, 'boolean' )" => [
                true, 'bool', true,
            ],
            "is( true, 'int' )" => [
                true, 'int', false,
            ],

            // Float / double
            "is( 1.5, 'float' )" => [
                1.5, 'float', true,
            ],
            "is( 1.5, 'double' )" => [
                1.5, 'double', true,
            ],
            "is( 1.5, 'int' )" => [
                1.5, 'int', false,
            ],

            // Function
            "is( 1, 'function' )" => [
                1, 'function', false,
            ],

            // String
            "is( 1, 'int' )" => [
                1, 'int', true,
            ],
            "is( 1, 'integer' )" => [
                1, 'integer', true,
            ],
            "is( 1, 'bool' )" => [
                1, 'bool', false,
            ],

            // Null
            "is( NULL, 'null' )" => [
                null, 'null', true,
            ],
            "is( null, 'null' )" => [
                null, 'null', true,
            ],
            "is( NULL, 'bool' )" => [
                null, 'bool', false,
            ],
            "is( NULL, 'int' )" => [
                null, 'int', false,
            ],

            // String
            "is( '1', 'string' )" => [
                '1', 'string', true,
            ],
            "is( '1', 'int' )" => [
                '1', 'int', false,
            ],
            "is( '1', 'bool' )" => [
                '1', 'bool', false,
            ],

            // Classes and interfaces

            // Classes
            "is( ReflectionFunction, 'ReflectionFunction' )" => [
                new \ReflectionFunction('substr'),
                'ReflectionFunction',
                true,
            ],
            "is( ReflectionFunction, 'ReflectionFunctionAbstract' )" => [
                new \ReflectionFunction('substr'),
                'ReflectionFunctionAbstract',
                true,
            ],
            "is( ReflectionFunction, 'ReflectionClass' )" => [
                new \ReflectionFunction('substr'),
                'ReflectionClass',
                false,
            ],
            "is( ReflectionFunction, 'int' )" => [
                new \ReflectionFunction('substr'),
                'int',
                false,
            ],

            // Interfaces
            "is( ReflectionFunction, 'Reflector' )" => [
                new \ReflectionFunction('substr'),
                'Reflector',
                true,
            ],
            "is( ReflectionFunction, 'Iterator' )" => [
                new \ReflectionFunction('substr'),
                'Iterator',
                false,
            ],
            "is( ReflectionFunction, 'int' )" => [
                new \ReflectionFunction('substr'),
                'int',
                false,
            ],
        ];
    }
}
