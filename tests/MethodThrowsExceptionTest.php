<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\FloatType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\Type\StringType;

/**
 * Tests constructor exceptions
 */
final class MethodThrowsExceptionTest extends \PHPUnit\Framework\TestCase
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
            'New ' . HashMap::class . ' with keyType of ArrayType' => [
                static function(): void {
                    new HashMap(new ArrayType(), new ArrayType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . HashMap::class . ' with keyType of BooleanType' => [
                static function(): void {
                    new HashMap(new BooleanType(), new BooleanType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . HashMap::class . ' with keyType of ClassType' => [
                static function(): void {
                    new HashMap(new ClassType(\Exception::class), new ClassType(\Exception::class));
                },
                \InvalidArgumentException::class,
            ],
            'New ' . HashMap::class . ' with keyType of FloatType' => [
                static function(): void {
                    new HashMap(new FloatType(), new FloatType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . HashMap::class . ' with keyType of InterfaceType' => [
                static function(): void {
                    new HashMap(new InterfaceType(\Throwable::class), new InterfaceType(\Throwable::class));
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . ' set() expects integer key, passed string' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->set('string', 1);
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . ' set() expects string key, passed integer' => [
                static  function(): void {
                    (new HashMap(new StringType(), new StringType()))->set(1, 'string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . ' set() expects integer value, passed string' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->set(1, 'string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . ' set() expects string value, passed integer' => [
                static  function(): void {
                    (new HashMap(new StringType(), new StringType()))->set('string', 1);
                },
                \InvalidArgumentException::class,
            ],
        ];
    }
}
