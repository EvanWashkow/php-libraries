<?php
declare(strict_types=1);

namespace PHP\Tests\Hashing\Hasher;

use PHP\Collections\ByteArray;
use PHP\Hashing\Hasher\IHasher;
use PHPUnit\Framework\TestCase;

/**
 * Factory that creates and returns IHasher instances, for testing
 */
class HasherFactory
{


    /**
     * Create an IHasher so that its hash() function returns the given ByteArray
     * @param ByteArray $returnValue
     * @return IHasher
     */
    public function hashReturns(ByteArray $returnValue): IHasher
    {
        return new class($returnValue) implements IHasher
        {
            private $returnValue;

            public function __construct(ByteArray $returnValue)
            {
                $this->returnValue = $returnValue;
            }

            public function hash($value): ByteArray
            {
                return $this->returnValue;
            }
        };
    }
}