<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\TestDefinition\EquatableInterface;

use EvanWashkow\PHPLibraries\EquatableInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests EquatableInterface implementations.
 */
abstract class AbstractEquatableInterfaceTestCase extends TestCase
{
    /**
     * Tests the EquatableInterface
     * 
     * @dataProvider getEqualsTestData
     */
    final public function testEquals(EquatableInterface $equatable, $value, bool $expected)
    {
        $this->assertSame(
            $expected,
            $equatable->equals($value)
        );
    }

    /**
     * Get the test data.
     * 
     * Use EquatableInterfaceTestBuilder to generate these tests.
     */
    abstract public function getEqualsTestData(): array;
}
