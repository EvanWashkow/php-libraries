<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Collection;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Collection\IntegerKeyHashMap;
use EvanWashkow\PHPLibraries\Collection\StringKeyHashMap;
use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;

final class MapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getGetSetTestData
     */
    public function testGetSet(Mapper $map, $key, $expected): void {
        $this->assertSame($expected, $map->get($key));
    }

    public function getGetSetTestData(): array {
        return array_merge(
            self::buildGetSetTestDataForIntKeyIntValue(new IntegerKeyHashMap(new IntegerType())),
            self::buildGetSetTestDataForStringKeyStringValue(new StringKeyHashMap(new StringType())),
            self::buildGetSetTestDataForIntKeyIntValue(new HashMap(new IntegerType(), new IntegerType())),
            self::buildGetSetTestDataForStringKeyStringValue(new HashMap(new StringType(), new StringType()))
        );
    }

    private static function buildGetSetTestDataForIntKeyIntValue(Mapper $map): array {
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

    private static function buildGetSetTestDataForStringKeyStringValue(Mapper $map): array {
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
}
