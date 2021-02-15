<?php
declare( strict_types = 1 );

namespace PHP\Tests\Hashing\HashAlgorithm;

use PHP\Collections\ByteArray;
use PHP\Hashing\HashAlgorithm\IHashAlgorithm;
use PHP\Hashing\HashAlgorithm\MD5;
use PHP\Hashing\HashAlgorithm\SHA1;
use PHP\Hashing\HashAlgorithm\SHA256;
use PHP\Hashing\HashAlgorithm\SHA384;
use PHP\Hashing\HashAlgorithm\SHA512;
use PHPUnit\Framework\TestCase;

/**
 * Tests the various IHashAlgorithm implementations (MD5, SHA1, SHA256, etc)
 */
final class HashAlgorithmImplementationTest extends TestCase
{


    /**
     * Test the Inheritance of each Hash Algorithm
     *
     * @dataProvider getInheritanceTestData
     *
     * @param $hashAlgorithm
     */
    public function testInheritance($hashAlgorithm): void
    {
        $this->assertInstanceOf(
            IHashAlgorithm::class,
            $hashAlgorithm,
            'Hash Algorithm does not implement IHashAlgorithm.'
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            MD5::class    => [ new MD5() ],
            SHA1::class   => [ new SHA1() ],
            SHA256::class => [ new SHA256() ],
            SHA384::class => [ new SHA384() ],
            SHA512::class => [ new SHA512() ]
        ];
    }


    /**
     * Test each Hash Algorithm's hash() function
     *
     * @dataProvider getHashTestData
     *
     * @param IHashAlgorithm $hashAlgorithm
     * @param ByteArray $value
     * @param string $expectedHash
     */
    public function testHash(IHashAlgorithm $hashAlgorithm, ByteArray $value, string $expectedHash): void
    {
        $this->assertEquals(
            $expectedHash,
            $hashAlgorithm->hash($value)->__toString(),
            'IHashAlgorithm->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        return [
            'md5(lorem)'    => [new MD5(),    new ByteArray('lorem'), \md5('lorem', true)],
            'md5(ipsum)'    => [new MD5(),    new ByteArray('ipsum'), \md5('ipsum', true)],
            'sha1(lorem)'   => [new SHA1(),   new ByteArray('lorem'), \sha1('lorem', true)],
            'sha1(ipsum)'   => [new SHA1(),   new ByteArray('ipsum'), \sha1('ipsum', true)],
            'sha256(lorem)' => [new SHA256(), new ByteArray('lorem'), \hash('sha256','lorem', true)],
            'sha256(ipsum)' => [new SHA256(), new ByteArray('ipsum'), \hash('sha256','ipsum', true)],
            'sha384(lorem)' => [new SHA384(), new ByteArray('lorem'), \hash('sha384','lorem', true)],
            'sha384(ipsum)' => [new SHA384(), new ByteArray('ipsum'), \hash('sha384','ipsum', true)],
            'sha512(lorem)' => [new SHA512(), new ByteArray('lorem'), \hash('sha512','lorem', true)],
            'sha512(ipsum)' => [new SHA512(), new ByteArray('ipsum'), \hash('sha512','ipsum', true)],
        ];
    }
}