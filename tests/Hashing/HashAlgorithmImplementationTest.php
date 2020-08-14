<?php
declare( strict_types = 1 );

namespace PHP\Tests\Hashing;

use PHP\Hashing\IHashAlgorithm;
use PHP\Hashing\MD5;
use PHPUnit\Framework\TestCase;

/**
 * Tests the various IHashAlgorithm implementations (MD5, SHA1, SHA256, etc)
 */
class HashAlgorithmImplementationTest extends TestCase
{


    /**
     * Test the Inheritance of each Hash Algorithm
     * 
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance( $object )
    {
        $this->assertInstanceOf(
            IHashAlgorithm::class,
            $object,
            'Hash Algorithm does not implement IHashAlgorithm.'
        );
    }

    public function getInheritanceTestData()
    {
        return [
            MD5::class => [ new MD5() ]
        ];
    }
}