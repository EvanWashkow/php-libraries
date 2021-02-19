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
     * @return array In the form [[Type, string|Type, bool]]
     */
    abstract public function getIsTestData(): array;


    /**
     * Invoke is() with the wrong argument type
     *
     * @param mixed $wrongArgumentType Wrong argument type for is()
     */
    abstract protected function callIsWithWrongArgumenttype($wrongArgumentType): void;


    /**
     * Ensure is() returns the expected results
     *
     * @dataProvider getIsTestData
     *
     * @param Type $type
     * @param string|Type $typeToCheck
     * @param bool $expected
     */
    final public function testIs(Type $type, $typeToCheck, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $type->is($typeToCheck),
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
        $this->callIsWithWrongArgumenttype($wrongArgumentType);
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
}
