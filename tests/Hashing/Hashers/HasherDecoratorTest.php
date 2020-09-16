<?php
declare(strict_types=1);

namespace PHP\Tests\Hashing\Hashers;

use PHP\Hashing\Hashers\HasherDecorator;
use PHP\Hashing\Hashers\IHasher;

/**
 * Tests HasherDecorator
 */
class HasherDecoratorTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Test inheritance
     */
    public function testInheritance(): void
    {
        $this->assertInstanceOf(
            IHasher::class,
            $this->createMock(HasherDecorator::class),
            'HasherDecorator not an instance of IHasher.'
        );
    }
}