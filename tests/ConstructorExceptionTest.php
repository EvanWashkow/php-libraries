<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests;

use EvanWashkow\PHPLibraries\Collection\PrimitiveKeyHashMap;
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
            'New ' . PrimitiveKeyHashMap::class . ' with keyType of ArrayType' => [
                static function(): void {
                    new PrimitiveKeyHashMap(new ArrayType(), new ArrayType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . PrimitiveKeyHashMap::class . ' with keyType of BooleanType' => [
                static function(): void {
                    new PrimitiveKeyHashMap(new BooleanType(), new BooleanType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . PrimitiveKeyHashMap::class . ' with keyType of ClassType' => [
                static function(): void {
                    new PrimitiveKeyHashMap(new ClassType(\Exception::class), new ClassType(\Exception::class));
                },
                \InvalidArgumentException::class,
            ],
            'New ' . PrimitiveKeyHashMap::class . ' with keyType of FloatType' => [
                static function(): void {
                    new PrimitiveKeyHashMap(new FloatType(), new FloatType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . PrimitiveKeyHashMap::class . ' with keyType of InterfaceType' => [
                static function(): void {
                    new PrimitiveKeyHashMap(new InterfaceType(\Throwable::class), new InterfaceType(\Throwable::class));
                },
                \InvalidArgumentException::class,
            ],
        ];
    }
}
