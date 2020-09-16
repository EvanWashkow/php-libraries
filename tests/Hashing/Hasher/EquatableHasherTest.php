<?php
declare(strict_types=1);

namespace PHP\Tests\Hashing\Hasher;

use PHP\Collections\ByteArray;
use PHP\Hashing\Hasher\HasherDecorator;
use PHP\Hashing\Hasher\IHasher;
use PHP\Hashing\Hasher\EquatableHasher;
use PHP\Interfaces\IEquatable;

/**
 * Tests ReturnEquatableHash
 */
class EquatableHasherTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            HasherDecorator::class,
            $this->createMock(EquatableHasher::class),
            'ReturnEquatableHash is not an instance of a HasherDecorator.'
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
            (new EquatableHasher($nextHasher))->hash($valueToHash)->__toString(),
            'ReturnEquatableHash->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        $hasherFactory  = new HasherFactory();
        $mockIHasher    = $this->createMock(IHasher::class);
        return [
            'hash( IEquatable->hash() === ByteArray(1) )' => [
                $mockIHasher,
                $this->createIEquatableWhoseHashReturns(new ByteArray(1)),
                new ByteArray(1)
            ],
            'hash( IEquatable->hash() === ByteArray(2) )' => [
                $mockIHasher,
                $this->createIEquatableWhoseHashReturns(new ByteArray(2)),
                new ByteArray(2)
            ],
            'hash( IEquatable->hash() === ByteArray(3) )' => [
                $mockIHasher,
                $this->createIEquatableWhoseHashReturns(new ByteArray(3)),
                new ByteArray(3)
            ],

            'hash(non-IEquatable) returns ByteArray(1)' => [
                $hasherFactory->hashReturns(new ByteArray(1)),
                'Not IEquatable',
                new ByteArray(1)
            ],
            'hash(non-IEquatable) returns ByteArray(2)' => [
                $hasherFactory->hashReturns(new ByteArray(2)),
                'Not IEquatable',
                new ByteArray(2)
            ],
            'hash(non-IEquatable) returns ByteArray(3)' => [
                $hasherFactory->hashReturns(new ByteArray(3)),
                'Not IEquatable',
                new ByteArray(3)
            ]
        ];
    }


    /**
     * Create an IEquatable whose hash() function returns the given ByteArray
     * @param ByteArray $returnValue
     * @return IEquatable
     */
    private function createIEquatableWhoseHashReturns(ByteArray $returnValue): IEquatable
    {
        $mockIEquatable = $this->createMock(IEquatable::class);
        $mockIEquatable = clone $mockIEquatable;
        $mockIEquatable->method('hash')->willReturn($returnValue);
        return $mockIEquatable;
    }
}