<?php
declare(strict_types=1);

namespace PHP\Tests\Hashing\Hasher;

use PHP\Hashing\Hasher\Hasher;
use PHP\Hashing\Hasher\IHasher;

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
}