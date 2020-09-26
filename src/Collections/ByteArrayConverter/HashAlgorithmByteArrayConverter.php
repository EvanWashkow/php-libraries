<?php
declare(strict_types=1);

namespace PHP\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\HashAlgorithm\IHashAlgorithm;

/**
 * Applies a Hash Algorithm to the Byte Array
 */
class HashAlgorithmByteArrayConverter extends ByteArrayConverterDecorator
{

    /** @var IHashAlgorithm $hashAlgorithm The Hash Algorithm to apply */
    private $hashAlgorithm;


    /**
     * HashAlgorithmByteArrayConverter constructor.
     *
     * @param IByteArrayConverter $byteArrayConverter Converts the value to a Byte Array to be processed by the Hash Algorithm
     * @param IHashAlgorithm $hashAlgorithm The Hash Algorithm to apply
     */
    public function __construct(IByteArrayConverter $byteArrayConverter, IHashAlgorithm $hashAlgorithm)
    {
        parent::__construct($byteArrayConverter);
        $this->hashAlgorithm = $hashAlgorithm;
    }


    /**
     * Applies the Hash Algorithm to the Byte Array, returning the result
     */
    public function convert($value): ByteArray
    {
        return $this->hashAlgorithm->hash($this->getNextConverter()->convert($value));
    }
}