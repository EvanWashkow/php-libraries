<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model\TestDefinition;

use PHP\Type\Model\Type;
use PHPUnit\Framework\TestCase;

/**
 * Defines a test for Type implementations that change on a per-instance basis
 *
 * Generally, these Type implementations have constructor arguments
 */
abstract class DynamicTypeTestDefinition extends TestCase
{
    /**
     * Return getName() test data
     */
    abstract public function getGetNameTestData(): array;


    /**
     * Return is() test data
     */
    abstract public function getIsTestData(): array;


    /**
     * Return isValueOfType() test data
     */
    abstract public function getIsValueOfTypeTestData(): array;


    /**
     * Tests getName()
     *
     * @dataProvider getGetNameTestData
     *
     * @param Type $type The Type
     * @param string $expected The expected type name
     */
    final public function testGetName(Type $type, string $expected): void
    {
        $this->assertEquals(
            $expected,
            $type->getName(),
            "{$this->getTypeClassName($type)}->getName() returned the wrong value."
        );
    }


    /**
     * Tests the is() function
     *
     * @dataProvider getIsTestData
     *
     * @param Type $typeA The Type
     * @param string|Type $typeB The Type or Type name to compare to
     * @param bool $expected The expected result
     */
    final public function testIs(Type $typeA, $typeB, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $typeA->is($typeB),
            "{$this->getTypeClassName($typeA)}->is() returned the wrong result."
        );
    }


    /**
     * Tests the isValueOfType() function
     *
     * @dataProvider getIsValueOfTypeTestData
     *
     * @param Type $type The Type
     * @param mixed $value The value
     * @param bool $expected The expected result
     */
    final public function testIsValueOfType(Type $type, $value, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $type->isValueOfType($value),
            "{$this->getTypeClassName($type)}->isValueOfType() returned the wrong result."
        );
    }


    /**
     * Retrieves the class name for the given Type instance
     *
     * @param Type $type The Type
     */
    private function getTypeClassName(Type $type): string
    {
        return get_class($type);
    }
}
