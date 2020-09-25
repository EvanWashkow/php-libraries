<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArrayConverter\IByteArrayConverter;
use PHP\Collections\ByteArrayConverter\SerializationByteArrayConverter;
use PHP\Serialization\PHPSerializer;

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
            new SerializationByteArrayConverter(new PHPSerializer()),
            SerializationByteArrayConverter::class . ' is not an instance of ' . IByteArrayConverter::class
        );
    }
}