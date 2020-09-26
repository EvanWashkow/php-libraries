<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArrayConverter\ByteArrayConverterDecorator;
use PHP\Collections\ByteArrayConverter\HashAlgorithmByteArrayConverter;
use PHP\Collections\ByteArrayConverter\SerializationByteArrayConverter;
use PHP\Hashing\HashAlgorithm\MD5;
use PHP\Serialization\PHPSerializer;

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
                new SerializationByteArrayConverter(new PHPSerializer()),
                new MD5()
            ),
            HashAlgorithmByteArrayConverter::class . ' is not an instance of '. ByteArrayConverterDecorator::class
        );
    }
}