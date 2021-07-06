<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Unit\Exception;

use EvanWashkow\PhpLibraries\Exception\Logic\NotExistsException;

/**
 * Tests custom exception types
 */
final class ExceptionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Tests the Exception type
     *
     * @dataProvider getTypeTestData
     *
     * @param \Throwable $throwable
     * @param string $expectedType
     */
    public function testType(\Throwable $throwable, string $expectedType): void
    {
        $this->assertInstanceOf(
            $expectedType,
            $throwable
        );
    }

    public function getTypeTestData(): array
    {
        return [
            NotExistsException::class => [new NotExistsException(), \LogicException::class],
        ];
    }
}
