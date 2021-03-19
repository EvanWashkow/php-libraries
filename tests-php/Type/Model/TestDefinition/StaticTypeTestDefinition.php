<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model\TestDefinition;

use PHP\Type\Model\Type;
use PHPUnit\Framework\TestCase;

/**
 * Defines a test for Type implementations that do not change on a per-instance basis
 *
 * Generally, these Type implementations do not take any arguments in the constructor
 */
abstract class StaticTypeTestDefinition extends TestCase
{
    /** @var ?Type The Type instance */
    private $type = null;


    /**
     * Return is() test data
     */
    abstract public function getIsTestData(): array;


    /**
     * Return isValueOfType() test data
     */
    abstract public function getIsValueOfTypeTestData(): array;


    /**
     * Creates a new Type instance to be tested
     */
    abstract protected function createType(): Type;


    /**
     * Tests the is() function
     *
     * @dataProvider getIsTestData
     *
     * @param string|Type $type The Type or Type name
     * @param bool $expected The expected result
     */
    final public function testIs($type, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $this->getOrCreateType()->is($type),
            "{$this->getTypeClassName()}->is() returned the wrong result."
        );
    }


    /**
     * Tests the isValueOfType() function
     *
     * @dataProvider getIsValueOfTypeTestData
     *
     * @param mixed $value The value
     * @param bool $expected The expected result
     */
    final public function testIsValueOfType($value, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $this->getOrCreateType()->isValueOfType($value),
            "{$this->getTypeClassName()}->isValueOfType() returned the wrong result."
        );
    }


    /**
     * Creates or returns a singleton instance of the Type to be tested
     */
    final protected function getOrCreateType(): Type
    {
        if (! $this->type instanceof Type)
        {
            $this->type = $this->createType();
        }
        return $this->type;
    }


    /**
     * Retrieves the Type class name
     */
    final protected function getTypeClassName(): string
    {
        return get_class($this->getOrCreateType());
    }
}
