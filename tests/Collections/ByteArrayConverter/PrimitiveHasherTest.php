<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\HasherDecorator;
use PHP\Collections\ByteArrayConverter\IHasher;
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
            HasherDecorator::class,
            $this->createMock(PrimitiveHasher::class),
            'PrimitiveHasher is not an instance of a HasherDecorator.'
        );
    }


    /**
     * Test the hash() function
     * @dataProvider getHashTestData
     * @param IHasher $nextHasher
     * @param $valueToHash
     * @param ByteArray $expected
     */
    public function testHash(IHasher $nextHasher, $valueToHash, ByteArray $expected): void
    {
        $this->assertEquals(
            $expected->__toString(),
            (new PrimitiveHasher($nextHasher))->hash($valueToHash)->__toString(),
            'PrimitiveHasher->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        $hasherFactory = new HasherFactory();
        $mockIHasher   = $this->createMock(IHasher::class);
        return [
            'hash(1)'        => [ $mockIHasher, 1,        new ByteArray(1)],
            'hash(1.1)'      => [ $mockIHasher, 1.1,      new ByteArray(1.1)],
            'hash("string")' => [ $mockIHasher, 'string', new ByteArray('string')],

            'hash(non-primitive) returns ByteArray(1)' => [
                $hasherFactory->hashReturns(new ByteArray(1)),
                new class {},
                new ByteArray(1)
            ],
            'hash(non-primitive) returns ByteArray(2)' => [
                $hasherFactory->hashReturns(new ByteArray(2)),
                new class {},
                new ByteArray(2)
            ],
            'hash(non-primitive) returns ByteArray(3)' => [
                $hasherFactory->hashReturns(new ByteArray(3)),
                new class {},
                new ByteArray(3)
            ]
        ];
    }
}