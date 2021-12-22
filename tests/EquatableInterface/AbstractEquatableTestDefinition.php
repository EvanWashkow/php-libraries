<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\EquatableInterface;

use EvanWashkow\PHPLibraries\EquatableInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests EquatableInterface implementations.
 */
abstract class AbstractEquatableTestDefinition extends TestCase
{
    /**
     * Tests the EquatableInterface
     * 
     * @dataProvider getTestData
     */
    final public function testEquatableInterface(EquatableInterface $equatable, $value, bool $expected)
    {
        $this->assertSame(
            $expected,
            $equatable->equals($value)
        );
    }

    /**
     * Get the test data.
     * 
     * Use EquatableTestDataBuilder to generate these tests.
     */
    abstract public function getTestData(): array;
}
