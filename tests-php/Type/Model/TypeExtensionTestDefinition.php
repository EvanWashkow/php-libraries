<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\Type;

/**
 * Tests classes that extend Type
 */
abstract class TypeExtensionTestDefinition extends \PHPUnit\Framework\TestCase
{
    /**
     * Retrieves is() test data
     *
     * @return array In the form [[Type $type, string|Type $isType, bool $expected]]
     */
    abstract public function getIsTestData(): array;


    /**
     * Retrieves isValueOfType() test data
     *
     * @return array In the form [[Type $type, mixed $value, bool $expected]]
     */
    abstract public function getIsValueOfTypeTestData(): array;


    /**
     * Invoke is() with the wrong argument type
     *
     * @param mixed $wrongArgumentType Wrong argument type for is()
     */
    abstract protected function callIsWithWrongArgumentType($wrongArgumentType): void;


    /**
     * Ensure is() returns the expected results
     *
     * @dataProvider getIsTestData
     *
     * @param Type $type
     * @param string|Type $isType
     * @param bool $expected
     */
    final public function testIs(Type $type, $isType, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $type->is($isType),
            Type::class . '->is() did not return the expected result.'
        );
    }


    /**
     * Ensure is() throws \InvalidArgumentException
     *
     * @dataProvider getIsThrowsInvalidArgumentExceptionTestData
     *
     * @param mixed $wrongArgumentType Wrong argument type for is()
     */
    final public function testIsThrowsInvalidArgumentException($wrongArgumentType): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->callIsWithWrongArgumentType($wrongArgumentType);
    }

    final public function getIsThrowsInvalidArgumentExceptionTestData(): array
    {
        return [
            'array'     => [[]],
            'bool'      => [true],
            'float'     => [-7.2],
            'int'       => [9],
            '\stdClass' => [new \stdClass()]
        ];
    }


    /**
     * Ensure isValueOfType() returns the expected results
     *
     * @dataProvider getIsValueOfTypeTestData
     *
     * @param Type $type
     * @param mixed $value
     * @param bool $expected
     */
    final public function testIsValueOfType(Type $type, $value, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $type->isValueOfType($value),
            Type::class . '->isValueOfType() did not return the expected result.'
        );
    }
}
