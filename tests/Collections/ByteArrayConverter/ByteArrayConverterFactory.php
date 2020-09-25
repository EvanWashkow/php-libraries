<?php
declare(strict_types=1);

namespace PHP\Tests\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\IByteArrayConverter;
use PHPUnit\Framework\TestCase;

/**
 * Factory that creates and returns IHasher instances, for testing
 */
class ByteArrayConverterFactory
{


    /**
     * Create an IHasher so that its hash() function returns the given ByteArray
     * @param ByteArray $returnValue
     * @return IByteArrayConverter
     */
    public function convertReturns(ByteArray $returnValue): IByteArrayConverter
    {
        return new class($returnValue) implements IByteArrayConverter
        {
            private $returnValue;

            public function __construct(ByteArray $returnValue)
            {
                $this->returnValue = $returnValue;
            }

            public function convert($value): ByteArray
            {
                return $this->returnValue;
            }
        };
    }
}