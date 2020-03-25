<?php
declare( strict_types = 1 );

namespace PHP\Tests\Exceptions;

use PHP\Exceptions\NotImplementedException;
use PHPUnit\Framework\TestCase;

/**
 * Test exceptions
 */
class ExceptionsTest extends TestCase
{


    /**
     * Test class inheritance
     * 
     * @dataProvider getClassInheritanceData
     */
    public function testClassInheritance( $exception, string $parentClassOrInterfaceName )
    {
        $this->assertInstanceOf(
            $parentClassOrInterfaceName,
            $exception,
            'Exception does not extend / implement expected parent class / interface.'
        );
    }

    public function getClassInheritanceData(): array
    {
        return [
            'NotImplementedException' => [
                new NotImplementedException(),
                \RuntimeException::class
            ]
        ];
    }
}