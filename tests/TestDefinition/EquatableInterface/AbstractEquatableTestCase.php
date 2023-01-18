<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\TestDefinition\EquatableInterface;

use EvanWashkow\PhpLibraries\Equatable;
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
     */
    final public function testEquals(Equatable $equatable, mixed $value, bool $expected): void
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
