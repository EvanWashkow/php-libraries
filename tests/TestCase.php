<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
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
                $message ?? "Wanted {$wantException}, got {$gotException} instead."
            );
        }
    }
}
