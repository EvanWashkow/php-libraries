<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Exceptions\NotImplementedException;
use PHP\Collections\ByteArrayConverter\ByteArrayConverterDecorator;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;

/**
 * Tests HasherDecorator
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
            'HasherDecorator not an instance of IHasher.'
        );
    }


    /**
     * Test __construct() and getNextHasher()
     * @param IByteArrayConverter $hasher
     * @dataProvider getConstructorAndGetNextTestData
     */
    public function testConstructorAndGetNext(IByteArrayConverter $hasher): void
    {
        // Create Hasher Decorator instance to test the __construct() and getNextHasher()
        $hasherDecorator = new class($hasher) extends ByteArrayConverterDecorator
        {
            public function convert($value): ByteArray
            {
                throw new NotImplementedException('Not implemented.');
            }

            public function getNextHasherTest(): IByteArrayConverter
            {
                return parent::getNextHasher();
            }
        };

        $this->assertEquals(
            $hasher,
            $hasherDecorator->getNextHasherTest(),
            'HasherDecorator->getNextHasher() does not return the expected IHasher instance.'
        );
    }

    public function getConstructorAndGetNextTestData(): array
    {
        $factory = new ByteArrayConverterFactory();
        return [
            'Hasher that returns ByteArray(1, 1)' => [
                $factory->convertReturns(new ByteArray(1, 1))
            ],
            'Hasher that returns ByteArray(2, 1)' => [
                $factory->convertReturns(new ByteArray(2, 1))
            ],
            'Hasher that returns ByteArray(3, 1)' => [
                $factory->convertReturns(new ByteArray(3, 1))
            ]
        ];
    }
}