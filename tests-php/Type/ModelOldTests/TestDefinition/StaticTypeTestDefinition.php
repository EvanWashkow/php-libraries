<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\ModelOldTests\TestDefinition;

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
     * Retrieve the data for the isOfType() function tests
     */
    abstract public function getIsOfTypeTestData(): array;


    /**
     * Retrieve the data for the isValueOfType() function tests
     */
    abstract public function getIsValueOfTypeTestData(): array;


    /**
     * Create a new Type instance to be tested
     */
    abstract protected function createType(): Type;


    /**
     * Retrieve the expected type name for this type
     */
    abstract protected function getExpectedTypeName(): string;


    /**
     * Retrieve the data for the isOfType() function tests
     */
    final public function getIsOfTypeNameTestData(): array
    {
        $typeNameTestData = [
            'invalid type name, or one that does not exist' => [
                'invalid type name',
                false
            ],
        ];
        foreach ($this->getIsOfTypeTestData() as $typeTestData)
        {
            $type               = $typeTestData[0];
            $expected           = $typeTestData[1];
            $typeNameTestData[] = [$type->getName(), $expected];
        }
        return array_merge(
            $typeNameTestData,
            $this->getIsOfTypeNameCustomTestData()
        );
    }


    /**
     * Tests the getName() function
     */
    final public function testGetName(): void
    {
        $this->assertEquals(
            $this->getExpectedTypeName(),
            $this->getOrCreateType()->getName(),
            "{$this->getTypeClassName()}->getName() returned the wrong result."
        );
    }


    /**
     * Tests the isOfType() function, via is()
     *
     * @dataProvider getIsOfTypeTestData
     *
     * @param Type $type The Type
     * @param bool $expected The expected result
     */
    final public function testIsOfType(Type $type, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $this->getOrCreateType()->is($type),
            "{$this->getTypeClassName()}->isOfType() returned the wrong result."
        );
    }


    /**
     * Tests the isOfType() function, via is()
     *
     * @dataProvider getIsOfTypeNameTestData
     *
     * @param string $type The Type name
     * @param bool $expected The expected result
     */
    final public function testIsOfTypeName(string $type, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $this->getOrCreateType()->is($type),
            "{$this->getTypeClassName()}->isOfTypeName() returned the wrong result."
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
     * Retrieve the Type class name
     */
    final protected function getTypeClassName(): string
    {
        return get_class($this->getOrCreateType());
    }


    /**
     * Retrieve custom data for the isOfType() function tests
     */
    protected function getIsOfTypeNameCustomTestData(): array
    {
        return [];
    }
}
