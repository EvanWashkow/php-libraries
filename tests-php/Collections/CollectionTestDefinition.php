<?php
declare(strict_types=1);

namespace PHP\Tests\Collections;

use PHP\Collections\Collection;
use PHPUnit\Framework\TestCase;

/**
 * Shared Collection tests
 */
abstract class CollectionTestDefinition extends TestCase
{
    /**
     * Retrieves serialization test data
     *
     * @return array<string, array<int, Collection>>
     */
    abstract public function getSerializationTestData(): array;


    /**
     * Ensures a Dictionary can be serialized / deserialized
     *
     * @dataProvider getSerializationTestData
     *
     * @param Collection $originalCollection
     */
    final public function testSerialization(Collection $originalCollection): void
    {
        /** @var Collection $deserializedCollection */
        $deserializedCollection = unserialize(serialize($originalCollection));

        // Do tests
        $this->assertSame(
            $originalCollection->getKeyType()->getName(),
            $deserializedCollection->getKeyType()->getName(),
            'DeserializedCollection->getKeyType() does not match the OriginalCollection->getKeyType()'
        );
        $this->assertSame(
            $originalCollection->getValueType()->getName(),
            $deserializedCollection->getValueType()->getName(),
            'DeserializedCollection->getValueType() does not match the OriginalCollection->getValueType()'
        );
        $this->assertEquals(
            $originalCollection->toArray(),
            $deserializedCollection->toArray(),
            'DeserializedCollection->toArray() does not match the OriginalCollection->toArray()'
        );
    }
}
