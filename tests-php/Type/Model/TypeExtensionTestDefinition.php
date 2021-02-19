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
}
