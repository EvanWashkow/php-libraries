<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;
use PHP\Collections\ByteArrayConverter\SerializationByteArrayConverter;
use PHP\Serialization\ISerializer;
use PHP\Serialization\PHPSerialization;

/**
 * Tests for SerializationByteArrayConverter
 */
class SerializationByteArrayConverterTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test inheritance
     */
    public function testInheritance()
    {
        $this->assertInstanceOf(
            IByteArrayConverter::class,
            new SerializationByteArrayConverter(new PHPSerialization()),
            SerializationByteArrayConverter::class . ' is not an instance of ' . IByteArrayConverter::class
        );
    }


    /**
     * Tests convert()
     *
     * @dataProvider getConvertData
     *
     * @param ISerializer $serializer
     * @param $value
     * @param ByteArray $expected
     */
    public function testConvert(ISerializer $serializer, $value): void
    {
        $expected = $serializer->serialize($value);
        $this->assertEquals(
            $expected->__toString(),
            (new SerializationByteArrayConverter($serializer))->convert($value)->__toString(),
            SerializationByteArrayConverter::class . '->convert() did not return the expected value.'
        );
    }

    public function getConvertData(): array
    {
        $phpSerializer = new PHPSerialization();
        return [
            'PHPSerializer, 1' => [
                $phpSerializer, 1
            ],
            'PHPSerializer, 2' => [
                $phpSerializer, 2
            ],
            'PHPSerializer, 3' => [
                $phpSerializer, 3
            ],

            'PHPSerializer, "1"' => [
                $phpSerializer, '1'
            ],
            'PHPSerializer, "2"' => [
                $phpSerializer, '2'
            ],
            'PHPSerializer, "3"' => [
                $phpSerializer, '3'
            ]
        ];
    }
}