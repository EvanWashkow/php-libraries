<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

final class HashMapTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getCountTestData
     */
    public function testCount(HashMap $map, int $expected): void {
        $this->assertSame($expected, $map->count());
    }

    public function getCountTestData(): array {
        return [
            HashMap::class . '->count() should return 0' => [
                new HashMap(new IntegerType(), new StringType()),
                0,
            ],
            HashMap::class . '->count() should return 2' => [
                (new HashMap(new IntegerType(), new StringType()))->set(0, 'foobar')->set(5, 'lorem'),
                2,
            ],
        ];
    }

    /**
     * @dataProvider getGetSetTestData
     */
    public function testGetSet(HashMap $map, $key, $expected): void {
        $this->assertSame($expected, $map->get($key));
    }

    public function getGetSetTestData(): array {
        return [
            HashMap::class . ' get(PHP_INT_MIN) should return PHP_INT_MAX' => [
                (new HashMap(new IntegerType(), new IntegerType()))->set(PHP_INT_MIN, PHP_INT_MAX),
                PHP_INT_MIN,
                PHP_INT_MAX,
            ],
            HashMap::class . ' get(PHP_INT_MAX) should return PHP_INT_MIN' => [
                (new HashMap(new IntegerType(), new IntegerType()))->set(PHP_INT_MAX, PHP_INT_MIN),
                PHP_INT_MAX,
                PHP_INT_MIN,
            ],
            HashMap::class . ' overriding key 0\'s value with 5 should return 5' => [
                (new HashMap(new IntegerType(), new IntegerType()))->set(0, 0)->set(0, 5),
                0,
                5,
            ],
            HashMap::class . ' get("foo") should return "bar"' => [
                (new HashMap(new StringType(), new StringType()))->set('foo', 'bar'),
                'foo',
                'bar',
            ],
            HashMap::class . ' get("bar") should return "foo"' => [
                (new HashMap(new StringType(), new StringType()))->set('bar', 'foo'),
                'bar',
                'foo',
            ],
            HashMap::class . ' overriding key "lorem"\'s value with "ipsum" should return "ipsum"' => [
                (new HashMap(new StringType(), new StringType()))->set('lorem', 'foobar')->set('lorem', 'ipsum'),
                'lorem',
                'ipsum',
            ],
        ];
    }

    /**
     * @dataProvider getGetKeyTypeTestData
     */
    public function testGetKeyType(HashMap $map, Type $expectedType): void {
        $mapType = new ClassType(get_class($map->getKeyType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Map->getKeyType() returned the wrong type');
    }

    public function getGetKeyTypeTestData(): array {
        return [
            IntegerType::class => [new HashMap(new IntegerType(), new ArrayType()), new IntegerType()],
            StringType::class => [new HashMap(new StringType(), new BooleanType()), new StringType()],
        ];
    }

    /**
     * @dataProvider getGetValueTypeTestData
     */
    public function testGetValueType(HashMap $map, Type $expectedType): void {
        $mapType = new ClassType(get_class($map->getValueType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Map->getValueType() returned the wrong type');
    }

    public function getGetValueTypeTestData(): array {
        return [
            ArrayType::class => [new HashMap(new IntegerType(), new ArrayType()), new ArrayType()],
            BooleanType::class => [new HashMap(new StringType(), new BooleanType()), new BooleanType()],
        ];
    }
}
