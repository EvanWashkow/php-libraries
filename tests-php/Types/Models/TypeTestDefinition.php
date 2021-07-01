<?php
declare(strict_types=1);

namespace PHP\Tests\Types\Models;

use PHP\Types\Models\Type;

/**
 * Shared tests for Type instances
 */
abstract class TypeTestDefinition extends \PHPUnit\Framework\TestCase
{
    /**
     * Retrieves serialization test data
     *
     * @return array<string, array<int, Type>>
     */
    abstract public function getSerializationTestData(): array;


    /**
     * Ensures a Type can be serialized / deserialized
     *
     * @dataProvider getSerializationTestData
     *
     * @param Type $originalType
     */
    final public function testSerialization(Type $originalType): void
    {
        // Prime Type->namesSequence by calling Type->getNames()
        $originalType->getNames();

        /** @var Type $deserializedType */
        $deserializedType = unserialize(serialize($originalType));

        // Do tests
        $this->assertSame(
            $originalType->getName(),
            $deserializedType->getName(),
            'DeserializedType->getName() does not match the OriginalType->getName()'
        );
        $this->assertSame(
            $originalType->getNames()->toArray(),
            $deserializedType->getNames()->toArray(),
            'DeserializedType->getNames() does not match the OriginalType->getNames()'
        );
    }
}
