<?php

declare(strict_types=1);

namespace PHP\Tests\Hashing\Hasher;

use PHP\Collections\ByteArray;
use PHP\Hashing\HashAlgorithm\SHA256;
use PHP\Hashing\Hasher\Hasher;
use PHP\Hashing\Hasher\IHasher;
use PHP\Interfaces\IEquatable;
use PHP\ObjectClass;
use PHP\Serialization\PHPSerialization;

/**
 * Tests for the Hasher class
 */
class HasherTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test class inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            IHasher::class,
            new Hasher()
        );
    }


    /**
     * Test hash() result
     *
     * @dataProvider getHashTestData
     *
     * @param $value
     * @param ByteArray $hash
     * @param bool $isEqual
     */
    public function testHash($value, ByteArray $hash, bool $isEqual): void
    {
        $hashString      = $hash->__toString();
        $valueHashString = (new Hasher())->hash($value)->__toString();
        if ($isEqual) {
            $this->assertEquals(
                $hashString,
                $valueHashString,
                'Hashing the value should return the ByteArray, but did not.'
            );
        } else {
            $this->assertNotEquals(
                $hashString,
                $valueHashString,
                'Hashing the value should not return the ByteArray, but did.'
            );
        }
    }

    public function getHashTestData(): array
    {
        // Array values
        $array1 = [ 1, 2, 3 ];
        $array2 = [ 'a', 'b', 'c' ];

        // Equatable hashes
        $equatable1Hash = new ByteArray('equatable1 hash');
        $equatable2Hash = new ByteArray('equatable2 hash');

        // Equatable values
        $equatable1 = $this->createMock(IEquatable::class);
        $equatable1->method('hash')->willReturn($equatable1Hash);
        $equatable2 = $this->createMock(IEquatable::class);
        $equatable2->method('hash')->willReturn($equatable2Hash);

        // stdClass values
        $stdClass1 = new \stdClass();
        $stdClass2 = new \stdClass();

        // Hash Algorithm and Serializer
        $hashAlgorithm = new SHA256();
        $serializer    = new PHPSerialization();

        return [

            // Primitives
            'true'                    => [ true,  new ByteArray(1, 1),  true ],
            'false'                   => [ false, new ByteArray(0, 1),  true ],
            '1'                       => [ 1,     new ByteArray(1),     true ],
            '2'                       => [ 2,     new ByteArray(2),     true ],
            '"abc"'                   => [ 'abc', new ByteArray('abc'), true ],
            '"xyz"'                   => [ 'xyz', new ByteArray('xyz'), true ],
            '1.5'                     => [ 1.5,   new ByteArray(1.5),   true ],
            '2.0'                     => [ 2.0,   new ByteArray(2.0),   true ],

            // Objects
            'equatable1'                => [ $equatable1, $equatable1Hash,                            true ],
            'equatable2'                => [ $equatable2, $equatable2Hash,                            true ],
            'equatable1 !== equatable2' => [ $equatable1, $equatable2Hash,                            false ],
            'stdClass1'                 => [ $stdClass1,  new ByteArray(spl_object_hash($stdClass1)), true ],
            'stdClass2'                 => [ $stdClass2,  new ByteArray(spl_object_hash($stdClass2)), true ],
            'stdClass1 !== stdClass2'   => [ $stdClass1,  new ByteArray(spl_object_hash($stdClass2)), false ],

            // Arrays
            'array1'                  => [ $array1, $hashAlgorithm->hash($serializer->serialize($array1)), true ],
            'array2'                  => [ $array2, $hashAlgorithm->hash($serializer->serialize($array2)), true ],
            'array1 !== array2'       => [ $array1, $hashAlgorithm->hash($serializer->serialize($array2)), false ]
        ];
    }
}
