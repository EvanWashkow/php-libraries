<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\TestDefinition\EquatableInterface;

use EvanWashkow\PHPLibraries\Equatable;
use PHPUnit\Framework\TestCase;

/**
 * Tests EquatableInterface implementations.
 */
abstract class AbstractEquatableTestCase extends TestCase
{
    /**
     * Tests the EquatableInterface.
     *
     * @dataProvider getEqualsTestData
     *
     * @param mixed $value
     */
    final public function testEquals(Equatable $equatable, $value, bool $expected): void
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
