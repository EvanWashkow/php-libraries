<?php
declare(strict_types=1);

namespace PHP\Tests\Hashing\Hasher;

use PHP\Collections\ByteArray;
use PHP\HashAlgorithm\SHA256;
use PHP\Hashing\Hasher\Hasher;
use PHP\Hashing\Hasher\IHasher;
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
        if ($isEqual)
        {
            $this->assertEquals(
                $hashString,
                $valueHashString,
                'Hashing the value should return the ByteArray, but did not.'
            );
        }
        else
        {
            $this->assertNotEquals(
                $hashString,
                $valueHashString,
                'Hashing the value should not return the ByteArray, but did.'
            );
        }
    }

    public function getHashTestData(): array
    {
        // Object values
        $stdClass1 = new \stdClass();
        $stdClass2 = new \stdClass();

        // Array values
        $array1 = [ 1, 2, 3 ];
        $array2 = [ 'a', 'b', 'c' ];

        // Hash Algorithm and Serializer
        $hashAlgorithm = new SHA256();
        $serializer    = new PHPSerialization();

        return [
            'true'                    => [ true,       new ByteArray(1, 1),                         true ],
            'false'                   => [ false,      new ByteArray(0, 1),                         true ],
            '1'                       => [ 1,          new ByteArray(1),                            true ],
            '2'                       => [ 2,          new ByteArray(2),                            true ],
            '"abc"'                   => [ 'abc',      new ByteArray('abc'),                        true ],
            '"xyz"'                   => [ 'xyz',      new ByteArray('xyz'),                        true ],
            '1.5'                     => [ 1.5,        new ByteArray(1.5),                          true ],
            '2.0'                     => [ 2.0,        new ByteArray(2.0),                          true ],
            'stdClass1'               => [ $stdClass1, new ByteArray(spl_object_hash($stdClass1)),          true ],
            'stdClass2'               => [ $stdClass2, new ByteArray(spl_object_hash($stdClass2)),          true ],
            'stdClass1 !== stdClass2' => [ $stdClass1, new ByteArray(spl_object_hash($stdClass2)),          false ],
            'array1'                  => [ $array1, $hashAlgorithm->hash($serializer->serialize($array1)),  true ],
            'array2'                  => [ $array2, $hashAlgorithm->hash($serializer->serialize($array2)),  true ],
            'array1 !== array2'       => [ $array1, $hashAlgorithm->hash($serializer->serialize($array2)),  false ]
        ];
    }
}