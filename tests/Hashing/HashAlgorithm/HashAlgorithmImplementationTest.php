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
            $hashAlgorithm->hash( $value )->__toString(),
            'IHashAlgorithm->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        // Variables
        $hashAlgorithms = [
            'md5'    => new MD5(),
            'sha1'   => new SHA1(),
            'sha256' => new SHA256(),
            'sha384' => new SHA384(),
            'sha512' => new SHA512()
        ];
        $values = [
            '1',
            '12',
            '123',
            '1234'
        ];
        $testData = [];

        // Build and return the Test Data
        foreach ($hashAlgorithms as $hashAlgorithmSlug => $hashAlgorithm) {
            foreach ( $values as $value ) {
                $testData[ "{$hashAlgorithmSlug}({$value})" ] =
                    $this->createHashTest($hashAlgorithm, $hashAlgorithmSlug, $value);
            }
        }
        return $testData;
    }


    /**
     * Create a new IHashAlgorithm->hash() test
     * 
     * @param IHashAlgorithm $hashAlgorithm     The Hash Algorithm to test
     * @param string         $hashAlgorithmSlug The Hash Algorithm slug
     * @param string         $value             The value to be hashed
     * @return array The test data
     */
    private function createHashTest(IHashAlgorithm $hashAlgorithm, string $hashAlgorithmSlug, string $value): array
    {
        return [
            $hashAlgorithm,
            new ByteArray( $value ),
            $this->computeHash($hashAlgorithmSlug, $value)
        ];
    }


    /**
     * Compute the Hash of a given string
     * 
     * @param string $hashAlgorithmSlug The Hash Algorithm slug (md5, sha1, sha256, etc.)
     * @param string $value             The value to hash
     * @return string The raw hash sum
     */
    private function computeHash( string $hashAlgorithmSlug, string $value ): string
    {
        return hash($hashAlgorithmSlug, $value, true);
    }
}