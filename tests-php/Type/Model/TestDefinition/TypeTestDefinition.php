<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model\TestDefinition;

use PHP\Type\Model\Type;

/**
 * Defines tests for a Type implementation
 */
abstract class TypeTestDefinition extends \PHPUnit\Framework\TestCase
{
    /**
     * Retrieve test data for getNames() test
     */
    abstract public function getNamesTestData(): array;


    /**
     * Return isValueOfType() test data
     */
    abstract public function getIsValueOfTypeTestData(): array;


    /**
     * Test getName() results
     *
     * @dataProvider getNamesTestData
     *
     * @param Type $type
     * @param string $expectedName
     */
    final public function testGetName(Type $type, string $expectedName): void
    {
        $this->assertEquals(
            $expectedName,
            $type->getName(),
            "{$this->getClassName($type)}->getName() did not return the expected type name."
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
            "{$this->getClassName($type)}->isValueOfType() returned the wrong result."
        );
    }


    /**
     * Retrieves the class name for the given Type instance
     *
     * @param Type $type The Type
     */
    private function getClassName(Type $type): string
    {
        return get_class($type);
    }
}
