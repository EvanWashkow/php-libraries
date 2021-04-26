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
            get_class($type) . '->getName() did not return the expected type name.'
        );
    }
}
