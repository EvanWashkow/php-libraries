<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Checks if the closure throws an exception
     *
     * @param string $wantException The expected exception
     * @param \Closure $func Function callback that throws the exception
     * @param string|null $message Message to output on failure
     */
    public function assertThrows(string $wantException, \Closure $func, ?string $message = null): void
    {
        $gotException = null;
        try {
            $func();
        } catch(\Throwable $t) {
            $gotException = $t;
        }
        if ($gotException === null) {
            $this->fail($message ?? 'no exception thrown');
        } else {
            $this->assertInstanceOf(
                $wantException,
                $gotException,
                $message ?? "Wanted exception {$wantException}, got exception {$gotException} instead."
            );
        }
    }
}
