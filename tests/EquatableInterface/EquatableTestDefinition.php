<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\EquatableInterface;

use PHPUnit\Framework\TestCase;

/**
 * Tests EquatableInterface implementations.
 */
abstract class AbstractEquatableTestDefinition extends TestCase
{
    /**
     * Tests the EquatableInterface
     * 
     * @dataProvider getTestCases
     */
    final public function testEquatableInterface(EquatableTestCase $test)
    {
        $this->assertSame(
            $test->getExpected(),
            $test->getEquatable()->equals($test->getValue()),
        );
    }

    /**
     * Get the EquatableTestCases
     *
     * @return array<EquatableTestCase>
     */
    abstract public function getTestCases(): array;
}
