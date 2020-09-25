<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\ByteArrayConverterDecorator;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;
use PHP\Collections\ByteArrayConverter\PrimitiveHasher;

/**
 * Tests PrimitiveHasher
 */
class PrimitiveHasherTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            ByteArrayConverterDecorator::class,
            $this->createMock(PrimitiveHasher::class),
            'PrimitiveHasher is not an instance of a HasherDecorator.'
        );
    }


    /**
     * Test the hash() function
     * @dataProvider getHashTestData
     * @param IByteArrayConverter $nextHasher
     * @param $valueToHash
     * @param ByteArray $expected
     */
    public function testHash(IByteArrayConverter $nextHasher, $valueToHash, ByteArray $expected): void
    {
        $this->assertEquals(
            $expected->__toString(),
            (new PrimitiveHasher($nextHasher))->convert($valueToHash)->__toString(),
            'PrimitiveHasher->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        $hasherFactory = new ByteArrayConverterFactory();
        $mockIHasher   = $this->createMock(IByteArrayConverter::class);
        return [
            'hash(1)'        => [ $mockIHasher, 1,        new ByteArray(1)],
            'hash(1.1)'      => [ $mockIHasher, 1.1,      new ByteArray(1.1)],
            'hash("string")' => [ $mockIHasher, 'string', new ByteArray('string')],

            'hash(non-primitive) returns ByteArray(1)' => [
                $hasherFactory->convertReturns(new ByteArray(1)),
                new class {},
                new ByteArray(1)
            ],
            'hash(non-primitive) returns ByteArray(2)' => [
                $hasherFactory->convertReturns(new ByteArray(2)),
                new class {},
                new ByteArray(2)
            ],
            'hash(non-primitive) returns ByteArray(3)' => [
                $hasherFactory->convertReturns(new ByteArray(3)),
                new class {},
                new ByteArray(3)
            ]
        ];
    }
}