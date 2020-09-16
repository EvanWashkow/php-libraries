<?php
declare(strict_types=1);

namespace PHP\Tests\Hashing\Hashers;

use PHP\Collections\ByteArray;
use PHP\Hashing\Hashers\HasherDecorator;
use PHP\Hashing\Hashers\IHasher;
use PHP\Hashing\Hashers\PrimitiveHasher;

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
            'PrimitimeHasher->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        $mockIHasher = $this->createMock(IHasher::class);
        return [
            'hash(1)'        => [ $mockIHasher, 1,        new ByteArray(1)],
            'hash(1.1)'      => [ $mockIHasher, 1.1,      new ByteArray(1.1)],
            'hash("string")' => [ $mockIHasher, 'string', new ByteArray('string')],

            'hash(non-primitive) returns ByteArray(1)' => [
                $this->createHasherThatReturns(new ByteArray(1)),
                new class {},
                new ByteArray(1)
            ],
            'hash(non-primitive) returns ByteArray(2)' => [
                $this->createHasherThatReturns(new ByteArray(2)),
                new class {},
                new ByteArray(2)
            ],
            'hash(non-primitive) returns ByteArray(3)' => [
                $this->createHasherThatReturns(new ByteArray(3)),
                new class {},
                new ByteArray(3)
            ]
        ];
    }


    /**
     * Create IHasher that returns the given value
     * @param ByteArray $returnValue
     * @return IHasher
     */
    private function createHasherThatReturns(ByteArray $returnValue): IHasher
    {
        $mockIHasher = $this->createMock(IHasher::class);
        $mockIHasher->method('hash')->willReturn( $returnValue );
        return $mockIHasher;
    }
}