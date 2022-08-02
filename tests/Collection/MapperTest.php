<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Collection;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;

final class MapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getGetSetRemoveKeyTestData
     */
    public function testGetSetRemoveKey(Mapper $map, $key, $expected): void {
        $this->assertSame($expected, $map->get($key));
    }

    public function getGetSetRemoveKeyTestData(): array {
        return [
            HashMap::class . ' after set(), get(PHP_INT_MIN) should return PHP_INT_MAX' => [
                (new HashMap(new IntegerType(), new IntegerType()))->set(PHP_INT_MIN, PHP_INT_MAX),
                PHP_INT_MIN,
                PHP_INT_MAX,
            ],
            HashMap::class . ' after set(), get(PHP_INT_MAX) should return PHP_INT_MIN' => [
                (new HashMap(new IntegerType(), new IntegerType()))->set(PHP_INT_MAX, PHP_INT_MIN),
                PHP_INT_MAX,
                PHP_INT_MIN,
            ],
            HashMap::class . ' after overriding the value with set(), key 0\'s value should return 5' => [
                (new HashMap(new IntegerType(), new IntegerType()))->set(0, 0)->set(0, 5),
                0,
                5,
            ],
            HashMap::class . ' after set(), get("foo") should return "bar"' => [
                (new HashMap(new StringType(), new StringType()))->set('foo', 'bar'),
                'foo',
                'bar',
            ],
            HashMap::class . ' after set(), get("bar") should return "foo"' => [
                (new HashMap(new StringType(), new StringType()))->set('bar', 'foo'),
                'bar',
                'foo',
            ],
            HashMap::class . ' after overriding the value with set(), key "lorem"\'s value should return "ipsum"' => [
                (new HashMap(new StringType(), new StringType()))->set('lorem', 'foobar')->set('lorem', 'ipsum'),
                'lorem',
                'ipsum',
            ],
        ];
    }
}
