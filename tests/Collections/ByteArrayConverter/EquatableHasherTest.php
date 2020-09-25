<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\ByteArrayConverterDecorator;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;
use PHP\Collections\ByteArrayConverter\EquatableHasher;
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
            ByteArrayConverterDecorator::class,
            $this->createMock(EquatableHasher::class),
            'ReturnEquatableHash is not an instance of a HasherDecorator.'
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
            (new EquatableHasher($nextHasher))->convert($valueToHash)->__toString(),
            'ReturnEquatableHash->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        $hasherFactory  = new ByteArrayConverterFactory();
        $mockIHasher    = $this->createMock(IByteArrayConverter::class);
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
                $hasherFactory->convertReturns(new ByteArray(1)),
                'Not IEquatable',
                new ByteArray(1)
            ],
            'hash(non-IEquatable) returns ByteArray(2)' => [
                $hasherFactory->convertReturns(new ByteArray(2)),
                'Not IEquatable',
                new ByteArray(2)
            ],
            'hash(non-IEquatable) returns ByteArray(3)' => [
                $hasherFactory->convertReturns(new ByteArray(3)),
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