<?php

namespace EvanWashkow\PHPLibraries\Tests\TestHelper;

use PHPUnit\Framework\TestCase;

/**
 * Helper class to test thrown exceptions
 */
final class ThrowsExceptionTestHelper
{
    private TestCase $tester;

    public function __construct(TestCase $tester) {
        $this->tester = $tester;
    }

    public function test(\Closure $closure, string $expectedExceptionClassName): void {
        $this->tester->expectException($expectedExceptionClassName);
        $closure();
    }
}