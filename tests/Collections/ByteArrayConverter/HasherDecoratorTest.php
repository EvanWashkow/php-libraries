<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Exceptions\NotImplementedException;
use PHP\Collections\ByteArrayConverter\HasherDecorator;
use PHP\Collections\ByteArrayConverter\IHasher;

/**
 * Tests HasherDecorator
 */
class HasherDecoratorTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            IHasher::class,
            $this->createMock(HasherDecorator::class),
            'HasherDecorator not an instance of IHasher.'
        );
    }


    /**
     * Test __construct() and getNextHasher()
     * @param IHasher $hasher
     * @dataProvider getConstructorAndGetNextTestData
     */
    public function testConstructorAndGetNext(IHasher $hasher): void
    {
        // Create Hasher Decorator instance to test the __construct() and getNextHasher()
        $hasherDecorator = new class($hasher) extends HasherDecorator
        {
            public function hash($value): ByteArray
            {
                throw new NotImplementedException('Not implemented.');
            }

            public function getNextHasherTest(): IHasher
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
        return [
            'Hasher that returns ByteArray(1, 1)' => [
                new class implements IHasher
                {
                    public function hash($value): ByteArray
                    {
                        return new ByteArray(1, 1);
                    }
                }
            ],
            'Hasher that returns ByteArray(2, 1)' => [
                new class implements IHasher
                {
                    public function hash($value): ByteArray
                    {
                        return new ByteArray(2, 1);
                    }
                }
            ],
            'Hasher that returns ByteArray(3, 1)' => [
                new class implements IHasher
                {
                    public function hash($value): ByteArray
                    {
                        return new ByteArray(3, 1);
                    }
                }
            ]
        ];
    }
}