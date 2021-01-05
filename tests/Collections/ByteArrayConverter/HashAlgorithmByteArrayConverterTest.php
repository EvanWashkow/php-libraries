<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\ByteArrayConverterDecorator;
use PHP\Collections\ByteArrayConverter\HashAlgorithmByteArrayConverter;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;
use PHP\Collections\ByteArrayConverter\SerializationByteArrayConverter;
use PHP\HashAlgorithm\IHashAlgorithm;
use PHP\HashAlgorithm\MD5;
use PHP\HashAlgorithm\SHA1;
use PHP\Serialization\PHPSerialization;

/**
 * Tests HashAlgorithmByteArrayConverter
 */
class HashAlgorithmByteArrayConverterTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test Inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            ByteArrayConverterDecorator::class,
            new HashAlgorithmByteArrayConverter(
                new SerializationByteArrayConverter(new PHPSerialization()),
                new MD5()
            ),
            HashAlgorithmByteArrayConverter::class . ' is not an instance of '. ByteArrayConverterDecorator::class
        );
    }


    /**
     * Ensures that convert() is a result of applying a Hash Algorithms to a Byte Array Converter
     *
     * @dataProvider getConvertTestData
     *
     * @param IByteArrayConverter $converter
     * @param IHashAlgorithm $hashAlgorithm
     * @param $value
     */
    public function testConvert(IByteArrayConverter $converter, IHashAlgorithm $hashAlgorithm, $value): void
    {
        // Compute the expected value
        $unhashedByteArray = $converter->convert($value);
        $hashedByteArray   = $hashAlgorithm->hash($unhashedByteArray);

        // Run test
        $hashAlgorithmConverter = new HashAlgorithmByteArrayConverter($converter, $hashAlgorithm);
        $this->assertEquals(
            $hashedByteArray->__toString(),
            $hashAlgorithmConverter->convert($value)->__toString(),
            HashAlgorithmByteArrayConverter::class . '->convert() did not return the expected value.'
        );
    }

    public function getConvertTestData(): array
    {
        // Byte Array Converters
        $phpSerializeByteArrayConverter = new SerializationByteArrayConverter(new PHPSerialization());
        $mockByteArrayConverter = (function() {
            $mock = $this->createMock(IByteArrayConverter::class);
            $mock->method('convert')->willReturn(new ByteArray(1));
            return $mock;
        })();

        // Hash Algorithms
        $md5 = new MD5();
        $sha1 = new SHA1();

        // Test Data
        return [
            'PHPSerializer, MD5, 1' => [ $phpSerializeByteArrayConverter, $md5, 1 ],
            'PHPSerializer, MD5, 2' => [ $phpSerializeByteArrayConverter, $md5, 2 ],
            'PHPSerializer, MD5, 3' => [ $phpSerializeByteArrayConverter, $md5, 3 ],

            'PHPSerializer, SHA1, 1' => [ $phpSerializeByteArrayConverter, $sha1, 1 ],
            'PHPSerializer, SHA1, 2' => [ $phpSerializeByteArrayConverter, $sha1, 2 ],
            'PHPSerializer, SHA1, 3' => [ $phpSerializeByteArrayConverter, $sha1, 3 ],

            'Mock ByteArrayConverter, MD5, 1' => [ $mockByteArrayConverter, $md5, 1 ],
            'Mock ByteArrayConverter, MD5, 2' => [ $mockByteArrayConverter, $md5, 2 ],
            'Mock ByteArrayConverter, MD5, 3' => [ $mockByteArrayConverter, $md5, 3 ],

            'Mock ByteArrayConverter, SHA1, 1' => [ $mockByteArrayConverter, $sha1, 1 ],
            'Mock ByteArrayConverter, SHA1, 2' => [ $mockByteArrayConverter, $sha1, 2 ],
            'Mock ByteArrayConverter, SHA1, 3' => [ $mockByteArrayConverter, $sha1, 3 ],
        ];
    }
}