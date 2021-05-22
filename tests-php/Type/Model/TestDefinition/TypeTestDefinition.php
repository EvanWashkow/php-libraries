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
     * Return is() test data
     */
    abstract public function getIsTestData(): array;

    /**
     * Return is('unknown type') test data
     */
    abstract public function getIsUnknownTypeNameTestData(): array;

    /**
     * Return isValueOf() test data
     */
    abstract public function getIsValueOfTypeTestData(): array;

    /**
     * Retrieve test data for getName() test
     */
    abstract public function getNameTestData(): array;


    /**
     * Test getName() results
     *
     * @dataProvider getNameTestData
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
     * Tests the Type->is() function
     *
     * @dataProvider getIsTestData
     *
     * @param Type $type The Type instance
     * @param string|Type $isFuncArg The Type->is() function argument. Specifying a Type instance will test both is()
     * overloaded implementations. Specifying a string will only test the is(string) implementation.
     * @param bool $expectedResult The expected result from Type->is()
     */
    final public function testIs(Type $type, $isFuncArg, bool $expectedResult): void
    {
        /**
         * Test Type->is(Type)
         */
        if ($isFuncArg instanceof Type)
        {
            $this->assertEquals(
                $expectedResult,
                $type->is($isFuncArg),
                "{$this->getClassName($type)}->is(Type) returned the wrong value."
            );

            // Call the test again, this time to test Type->is(string $typeName)
            $this->testIs($type, $isFuncArg->getName(), $expectedResult);
        }

        /**
         * Test Type->is(string)
         */
        elseif (is_string($isFuncArg))
        {
            $this->assertEquals(
                $expectedResult,
                $type->is($isFuncArg),
                "{$this->getClassName($type)}->is(string) returned the wrong value."
            );
        }

        /**
         * Somebody wrote the test wrong
         */
        else
        {
            throw new \InvalidArgumentException('$isFuncArg expected to be a Type or a string.');
        }
    }


    /**
     * Test Type->is('unknown type') returns false
     *
     * @dataProvider getIsUnknownTypeNameTestData
     *
     * @param Type $type The Type instance to test
     */
    final public function testIsUnknownTypeName(Type $type): void
    {
        $this->assertEquals(
            false,
            $type->is('unknown type'),
            "{$this->getClassName($type)}->is('unknown type') returned the wrong value."
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
