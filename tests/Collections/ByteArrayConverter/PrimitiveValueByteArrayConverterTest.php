<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\ByteArrayConverterDecorator;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;
use PHP\Collections\ByteArrayConverter\PrimitiveValueByteArrayConverter;

/**
 * Tests PrimitiveValueByteArrayConverter
 */
class PrimitiveValueByteArrayConverterTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            ByteArrayConverterDecorator::class,
            $this->createMock(PrimitiveValueByteArrayConverter::class),
            'PrimitiveValueByteArrayConverter is not an instance of a ByteArrayConverterDecorator.'
        );
    }


    /**
     * Test the convert() function
     * @dataProvider getConvertTestData
     * @param IByteArrayConverter $nextHasher
     * @param $value
     * @param ByteArray $expected
     */
    public function testConvert(IByteArrayConverter $nextHasher, $value, ByteArray $expected): void
    {
        $this->assertEquals(
            $expected->__toString(),
            (new PrimitiveValueByteArrayConverter($nextHasher))->convert($value)->__toString(),
            'PrimitiveValueByteArrayConverter->convert() did not return the expected value.'
        );
    }

    public function getConvertTestData(): array
    {
        $converterFactory = new ByteArrayConverterFactory();
        $mockConverter    = $this->createMock(IByteArrayConverter::class);
        return [
            'hash(1)'        => [ $mockConverter, 1,        new ByteArray(1)],
            'hash(1.1)'      => [ $mockConverter, 1.1,      new ByteArray(1.1)],
            'hash("string")' => [ $mockConverter, 'string', new ByteArray('string')],

            'hash(non-primitive) returns ByteArray(1)' => [
                $converterFactory->convertReturns(new ByteArray(1)),
                new class {},
                new ByteArray(1)
            ],
            'hash(non-primitive) returns ByteArray(2)' => [
                $converterFactory->convertReturns(new ByteArray(2)),
                new class {},
                new ByteArray(2)
            ],
            'hash(non-primitive) returns ByteArray(3)' => [
                $converterFactory->convertReturns(new ByteArray(3)),
                new class {},
                new ByteArray(3)
            ]
        ];
    }
}