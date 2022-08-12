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
     * Tests accessor methods, like get(), set(), add(), and etc.
     *
     * @dataProvider getAccessorTests
     */
    public function testAccessors(Mapper $map, $key, $expected): void {
        $this->assertSame($expected, $map->get($key));
    }

    public function getAccessorTests(): array {
        return array_merge(

            // IntegerKeyHashSet
            self::buildAccessorTest(
                (new IntegerKeyHashMap(new IntegerType()))->set(PHP_INT_MIN, PHP_INT_MAX),
                PHP_INT_MIN,
                PHP_INT_MAX
            ),
            self::buildAccessorTest(
                (new IntegerKeyHashMap(new IntegerType()))->set(PHP_INT_MAX, PHP_INT_MIN),
                PHP_INT_MAX,
                PHP_INT_MIN
            ),
            self::buildAccessorTest(
                (new IntegerKeyHashMap(new IntegerType()))->set(0, 0)->set(0, 5),
                0,
                5,
                'After overriding key 0, ' . IntegerKeyHashMap::class . '->get(0) should return 5'
            ),

            // StringKeyHashSet
            self::buildAccessorTest(
                (new StringKeyHashMap(new StringType()))->set('foo', 'bar'),
                'foo',
                'bar',
            ),
            self::buildAccessorTest(
                (new StringKeyHashMap(new StringType()))->set('bar', 'foo'),
                'bar',
                'foo',
            ),
            self::buildAccessorTest(
                (new StringKeyHashMap(new StringType()))->set('lorem', 'foobar')->set('lorem', 'ipsum'),
                'lorem',
                'ipsum',
                'After overriding key lorem, ' . StringKeyHashMap::class . '->get(lorem) should return ipsum'
            ),

            // HashSet
            self::buildAccessorTest(
                (new HashMap(new IntegerType(), new IntegerType()))->set(PHP_INT_MIN, PHP_INT_MAX),
                PHP_INT_MIN,
                PHP_INT_MAX
            ),
            self::buildAccessorTest(
                (new HashMap(new IntegerType(), new IntegerType()))->set(PHP_INT_MAX, PHP_INT_MIN),
                PHP_INT_MAX,
                PHP_INT_MIN
            ),
            self::buildAccessorTest(
                (new HashMap(new IntegerType(), new IntegerType()))->set(0, 0)->set(0, 5),
                0,
                5,
                'After overriding key 0, ' . HashMap::class . '->get(0) should return 5'
            ),
            self::buildAccessorTest(
                (new HashMap(new StringType(), new StringType()))->set('foo', 'bar'),
                'foo',
                'bar',
            ),
            self::buildAccessorTest(
                (new HashMap(new StringType(), new StringType()))->set('bar', 'foo'),
                'bar',
                'foo',
            ),
            self::buildAccessorTest(
                (new HashMap(new StringType(), new StringType()))->set('lorem', 'foobar')->set('lorem', 'ipsum'),
                'lorem',
                'ipsum',
                'After overriding key lorem, ' . HashMap::class . '->get(lorem) should return ipsum'
            ),
        );
    }

    private static function buildAccessorTest(Mapper $map, $key, $expected, string $message = ""): array {
        $message = $message === "" ? get_class($map) . "->get({$key}) should return {$expected}" : $message;
        return [
            $message => [ $map, $key, $expected ],
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

    /**
     * @dataProvider getGetValueTypeTests
     */
    public function testGetValueType(Mapper $map, Type $expectedType): void {
        $mapType = new ClassType(get_class($map->getValueType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Mapper->getValueType() returned the wrong type');
    }

    public function getGetValueTypeTests(): array {
        return [
            IntegerKeyHashMap::class . ' value type should return ' . BooleanType::class => [
                new IntegerKeyHashMap(new BooleanType()), new BooleanType(),
            ],
            StringKeyHashMap::class . ' value type should return ' . IntegerType::class => [
                new StringKeyHashMap(new IntegerType()), new IntegerType(),
            ],
            HashMap::class . ' with ' . ArrayType::class . ' value type should return that type' => [
                new HashMap(new IntegerType(), new ArrayType()), new ArrayType(),
            ],
            HashMap::class . ' with ' . BooleanType::class . ' value type should return that type' => [
                new HashMap(new StringType(), new BooleanType()), new BooleanType(),
            ],
        ];
    }

    /**
     * @dataProvider getHasKeyTests
     */
    public function testHasKey(Mapper $map, $key, bool $expected): void {
        $this->assertSame($expected, $map->hasKey($key));
    }

    public function getHasKeyTests(): array {
        return array_merge(

            // IntegerKeyHashMap
            self::buildHasKeyTest(
                (new IntegerKeyHashMap(new IntegerType()))->set(1, 5),
                1,
                true
            ),
            self::buildHasKeyTest(
                (new IntegerKeyHashMap(new IntegerType()))->set(2, 7),
                1,
                false,
            ),

            // StringKeyHashMap
            self::buildHasKeyTest(
                (new StringKeyHashMap(new StringType()))->set('foo', 'bar'),
                'foo',
                true,
            ),
            self::buildHasKeyTest(
                (new StringKeyHashMap(new StringType()))->set('lorem', 'ipsum'),
                'foo',
                false,
            ),

            // HashMap
            self::buildHasKeyTest(
                (new HashMap(new IntegerType(), new IntegerType()))->set(1, 5),
                1,
                true
            ),
            self::buildHasKeyTest(
                (new HashMap(new IntegerType(), new IntegerType()))->set(2, 7),
                1,
                false,
            ),
            self::buildHasKeyTest(
                (new HashMap(new StringType(), new StringType()))->set('foo', 'bar'),
                'foo',
                true,
            ),
            self::buildHasKeyTest(
                (new HashMap(new StringType(), new StringType()))->set('lorem', 'ipsum'),
                'foo',
                false,
            ),
        );
    }

    public static function buildHasKeyTest(Mapper $map, $key, bool $expected): array {
        return [
            get_class($map) . '->hasKey() returns ' . ($expected ? 'true' : 'false') . ' for key ' . $key => [
                $map, $key, $expected,
            ],
        ];
    }
}
