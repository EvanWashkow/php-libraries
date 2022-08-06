<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Collection;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Collection\IntegerKeyHashMap;
use EvanWashkow\PHPLibraries\Collection\StringKeyHashMap;
use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

final class MapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getGetSetTests
     */
    public function testGetSet(Mapper $map, $key, $expected): void {
        $this->assertSame($expected, $map->get($key));
    }

    public function getGetSetTests(): array {
        return array_merge(
            self::buildGetSetIntKeyValueMapperTests(new IntegerKeyHashMap(new IntegerType())),
            self::buildGetSetStringKeyValueMapperTests(new StringKeyHashMap(new StringType())),
            self::buildGetSetIntKeyValueMapperTests(new HashMap(new IntegerType(), new IntegerType())),
            self::buildGetSetStringKeyValueMapperTests(new HashMap(new StringType(), new StringType()))
        );
    }

    private static function buildGetSetIntKeyValueMapperTests(Mapper $map): array {
        $class = get_class($map);
        return [
            "{$class} after set(), get(PHP_INT_MIN) should return PHP_INT_MAX" => [
                $map->set(PHP_INT_MIN, PHP_INT_MAX),
                PHP_INT_MIN,
                PHP_INT_MAX,
            ],
            "{$class} after set(), get(PHP_INT_MAX) should return PHP_INT_MIN" => [
                $map->set(PHP_INT_MAX, PHP_INT_MIN),
                PHP_INT_MAX,
                PHP_INT_MIN,
            ],
            "{$class} after overriding the value with set(), key 0 should return value 5"=> [
                $map->set(0, 0)->set(0, 5),
                0,
                5,
            ],
        ];
    }

    private static function buildGetSetStringKeyValueMapperTests(Mapper $map): array {
        $class = get_class($map);
        return [
            "{$class} after set(), get('foo') should return 'bar'" => [
                (new HashMap(new StringType(), new StringType()))->set('foo', 'bar'),
                'foo',
                'bar',
            ],
            "{$class} after set(), get('bar') should return 'foo'" => [
                (new HashMap(new StringType(), new StringType()))->set('bar', 'foo'),
                'bar',
                'foo',
            ],
            "{$class} after overriding the value with set(), key 'lorem' should return value 'ipsum'" => [
                (new HashMap(new StringType(), new StringType()))->set('lorem', 'foobar')->set('lorem', 'ipsum'),
                'lorem',
                'ipsum',
            ],
        ];
    }

    /**
     * @dataProvider getGetKeyTypeTests
     */
    public function testGetKeyType(Mapper $map, Type $expectedType): void {
        $mapType = new ClassType(get_class($map->getKeyType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Mapper->getKeyType() returned the wrong type');
    }

    public function getGetKeyTypeTests(): array {
        return [
            IntegerKeyHashMap::class . ' key type should return ' . IntegerType::class => [
                new IntegerKeyHashMap(new BooleanType()), new IntegerType(),
            ],
            StringKeyHashMap::class . ' key type should return ' . StringType::class => [
                new StringKeyHashMap(new IntegerType()), new StringType(),
            ],
            HashMap::class . ' with ' . IntegerType::class . ' key type should return that type' => [
                new HashMap(new IntegerType(), new ArrayType()), new IntegerType(),
            ],
            HashMap::class . ' with ' . StringType::class . ' key type should return that type' => [
                new HashMap(new StringType(), new BooleanType()), new StringType(),
            ],
        ];
    }
}
