<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Exceptions\NotImplementedException;
use PHP\Collections\ByteArrayConverter\ByteArrayConverterDecorator;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;

/**
 * Tests ByteArrayConverterDecorator
 */
class ByteArrayConverterDecoratorTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            IByteArrayConverter::class,
            $this->createMock(ByteArrayConverterDecorator::class),
            'ByteArrayConverterDecorator not an instance of IByteArrayConverter.'
        );
    }


    /**
     * Test __construct() and getNextConverter()
     * @param IByteArrayConverter $converter
     * @dataProvider getConstructorAndGetNextTestData
     */
    public function testConstructorAndGetNext(IByteArrayConverter $converter): void
    {
        // Create Byte Array Converter Decorator instance to test the __construct() and getNextConverter()
        $converterDecorator = new class($converter) extends ByteArrayConverterDecorator
        {
            public function convert($value): ByteArray
            {
                throw new NotImplementedException('Not implemented.');
            }

            public function getNextConverterTest(): IByteArrayConverter
            {
                return parent::getNextConverter();
            }
        };

        $this->assertEquals(
            $converter,
            $converterDecorator->getNextConverterTest(),
            'ByteArrayConverterDecorator->getNextConverter() does not return the original IByteArrayConverter instance.'
        );
    }

    public function getConstructorAndGetNextTestData(): array
    {
        $factory = new ByteArrayConverterFactory();
        return [
            'Byte Array Converter that returns ByteArray(1, 1)' => [
                $factory->convertReturns(new ByteArray(1, 1))
            ],
            'Byte Array Converter that returns ByteArray(2, 1)' => [
                $factory->convertReturns(new ByteArray(2, 1))
            ],
            'Byte Array Converter that returns ByteArray(3, 1)' => [
                $factory->convertReturns(new ByteArray(3, 1))
            ]
        ];
    }
}