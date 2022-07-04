<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests;

use EvanWashkow\PHPLibraries\Collection\Map;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\FloatType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;

/**
 * Tests constructor exceptions
 */
final class ConstructorExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getTestData
     */
    public function test(\Closure $closure, string $expectedExceptionClassName): void {
        $this->expectException($expectedExceptionClassName);
        $closure();
    }

    public function getTestData(): array {
        return [
            'New ' . Map::class . ' with keyType of ArrayType' => [
                static function(): void {
                    new Map(new ArrayType(), new ArrayType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . Map::class . ' with keyType of BooleanType()' => [
                static function(): void {
                    new Map(new BooleanType(), new BooleanType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . Map::class . ' with keyType of ClassType()' => [
                static function(): void {
                    new Map(new ClassType(\Exception::class), new ClassType(\Exception::class));
                },
                \InvalidArgumentException::class,
            ],
            'New ' . Map::class . ' with keyType of FloatType()' => [
                static function(): void {
                    new Map(new FloatType(), new FloatType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . Map::class . ' with keyType of InterfaceType()' => [
                static function(): void {
                    new Map(new InterfaceType(\Throwable::class), new InterfaceType(\Throwable::class));
                },
                \InvalidArgumentException::class,
            ],
        ];
    }
}
