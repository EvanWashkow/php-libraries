<?php
declare( strict_types = 1 );

namespace PHP\Hashing\Hasher;

use PHP\Hashing\HashAlgorithms\MD5;
use PHP\Hashing\Hashers\IHasher;
use PHP\Hashing\Hashers\SerializingHasher;
use PHP\Serialization\PHPSerializer;
use PHPUnit\Framework\TestCase;

/**
 * Tests SerializingHasher
 */
class SerializingHasherTest extends TestCase
{


    /**
     * Test Inheritance
     */
    public function testInheritance()
    {
        $this->assertInstanceOf(
            IHasher::class,
            new SerializingHasher( new PHPSerializer(), new MD5() ),
            'SerializingHasher is not an instance of IHasher.'
        );
    }
}