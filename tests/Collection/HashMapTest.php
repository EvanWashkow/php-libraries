<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Collection;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Tests\TestHelper\ThrowsExceptionTestHelper;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\FloatType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\Type\StringType;

final class HashMapTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getThrowsExceptionTestData
     */
    public function testThrowsException(\Closure $closure, string $expectedExceptionClassName): void {
        (new ThrowsExceptionTestHelper($this))->test($closure, $expectedExceptionClassName);
    }

    public function getThrowsExceptionTestData(): array {
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
            HashMap::class . '->get() expects integer key, passed string' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->get('string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->get() expects string key, passed integer' => [
                static  function(): void {
                    (new HashMap(new StringType(), new StringType()))->get(1);
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->get(); key does not exist' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))
                        ->set(1, 2)
                        ->get(5);
                },
                \OutOfBoundsException::class,
            ],
            HashMap::class . '->get() should throw exception after the key was removed' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))
                        ->set(1, 2)
                        ->removeKey(1)
                        ->get(1);
                },
                \OutOfBoundsException::class,
            ],
            HashMap::class . '->hasKey() expects integer key, passed string' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->hasKey('string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->hasKey() expects string key, passed integer' => [
                static  function(): void {
                    (new HashMap(new StringType(), new StringType()))->hasKey(1);
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->removeKey() expects integer key, passed string' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->removeKey('string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->removeKey() expects string key, passed integer' => [
                static  function(): void {
                    (new HashMap(new StringType(), new StringType()))->removeKey(1);
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->removeKey(); key does not exist' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))
                        ->set(1, 2)
                        ->removeKey(5);
                },
                \OutOfBoundsException::class,
            ],
            HashMap::class . '->set() expects integer key, passed string' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->set('string', 1);
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->set() expects string key, passed integer' => [
                static  function(): void {
                    (new HashMap(new StringType(), new StringType()))->set(1, 'string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->set() expects integer value, passed string' => [
                static  function(): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->set(1, 'string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->set() expects string value, passed integer' => [
                static  function(): void {
                    (new HashMap(new StringType(), new StringType()))->set('string', 1);
                },
                \InvalidArgumentException::class,
            ],
        ];
    }
}
