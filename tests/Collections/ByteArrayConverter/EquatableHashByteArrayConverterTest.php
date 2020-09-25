<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\ByteArrayConverterDecorator;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;
use PHP\Collections\ByteArrayConverter\EquatableHashByteArrayConverter;
use PHP\Interfaces\IEquatable;

/**
 * Tests EquatableHashByteArrayConverter
 */
class EquatableHashByteArrayConverterTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            ByteArrayConverterDecorator::class,
            $this->createMock(EquatableHashByteArrayConverter::class),
            'EquatableHashByteArrayConverter is not an instance of a ByteArrayConverterDecorator.'
        );
    }


    /**
     * Test the convert() function
     * @dataProvider getHashTestData
     * @param IByteArrayConverter $nextConverter
     * @param $value
     * @param ByteArray $expected
     */
    public function testHash(IByteArrayConverter $nextConverter, $value, ByteArray $expected): void
    {
        $this->assertEquals(
            $expected->__toString(),
            (new EquatableHashByteArrayConverter($nextConverter))->convert($value)->__toString(),
            'EquatableHashByteArrayConverter->convert() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        $converterFactory = new ByteArrayConverterFactory();
        $mockConverter   = $this->createMock(IByteArrayConverter::class);
        return [
            'convert( IEquatable->hash() === ByteArray(1) )' => [
                $mockConverter,
                $this->createIEquatableWhoseHashReturns(new ByteArray(1)),
                new ByteArray(1)
            ],
            'convert( IEquatable->hash() === ByteArray(2) )' => [
                $mockConverter,
                $this->createIEquatableWhoseHashReturns(new ByteArray(2)),
                new ByteArray(2)
            ],
            'convert( IEquatable->hash() === ByteArray(3) )' => [
                $mockConverter,
                $this->createIEquatableWhoseHashReturns(new ByteArray(3)),
                new ByteArray(3)
            ],

            'convert(non-IEquatable) returns ByteArray(1)' => [
                $converterFactory->convertReturns(new ByteArray(1)),
                'Not IEquatable',
                new ByteArray(1)
            ],
            'convert(non-IEquatable) returns ByteArray(2)' => [
                $converterFactory->convertReturns(new ByteArray(2)),
                'Not IEquatable',
                new ByteArray(2)
            ],
            'convert(non-IEquatable) returns ByteArray(3)' => [
                $converterFactory->convertReturns(new ByteArray(3)),
                'Not IEquatable',
                new ByteArray(3)
            ]
        ];
    }


    /**
     * Create an IEquatable whose convert() function returns the given ByteArray
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