<?php
declare(strict_types=1);

namespace PHP\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Serialization\ISerializer;

/**
 * Converts a value to a Byte Array using the specified Serializer
 */
class SerializationByteArrayConverter implements IByteArrayConverter
{

    /** @var ISerializer $serializer The serializer to use to convert the value to Byte Array */
    private $serializer;


    /**
     * Creates a new Serialization Byte Array Converter instance
     *
     * @param ISerializer $serializer The serializer to use to convert the value to Byte Array
     */
    public function __construct(ISerializer $serializer)
    {
        $this->serializer = $serializer;
    }


    public function convert($value): ByteArray
    {
        return $this->serializer->serialize($value);
    }
}