<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Collection;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Collection\IntegerKeyHashMap;
use EvanWashkow\PHPLibraries\Collection\StringKeyHashMap;
use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Tests\TestHelper\ThrowsExceptionTestHelper;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\FloatType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

final class MapperTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getSetTests
     *
     * @param Mapper $map
     * @param $key
     * @param $value
     * @param string|null $wantException
     * @return void
     */
    public function testSet(Mapper $map, $key, $value, ?string $wantException) : void {
        if ($wantException != null) {
            $this->expectException($wantException);
        }
        $this->assertSame($value, $map->set($key, $value)->get($key), 'Map did not set the value');
    }

    public function getSetTests(): array {
        return array_merge(
            self::buildIntegerKeySetTests(
                function (Type $type) { return new IntegerKeyHashMap($type); },
                IntegerKeyHashMap::class
            ),
            self::buildStringKeySetTests(
                function (Type $type) { return new StringKeyHashMap($type); },
                StringKeyHashMap::class
            ),

            // HashMap
            self::buildIntegerKeySetTests(
                function (Type $type) { return new HashMap(new IntegerType(), $type); },
                HashMap::class
            ),
            self::buildStringKeySetTests(
                function (Type $type) { return new HashMap(new StringType(), $type); },
                HashMap::class
            ),
        );
    }

    private static function buildIntegerKeySetTests(\Closure $new, string $className): array {
        $prefix = 'Integer key set tests';
        return [
            "{$prefix} - {$className} set 1 to 2" => [
                $new(new IntegerType()), 1, 2, null
            ],
            "{$prefix} - {$className} set 1 to two" => [
                $new(new StringType()), 1, 'two', null
            ],
            "{$prefix} - {$className} set 2 to 1" => [
                $new(new IntegerType()), 2, 1, null
            ],
            "{$prefix} - {$className} set 2 to one" => [
                $new(new StringType()), 2, 'one', null
            ],
            "{$prefix} - {$className} set expects integer key, float given" => [
                $new(new IntegerType()), .5, 1, \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects integer key, string given" => [
                $new(new IntegerType()), 'one', 1, \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects integer value, float given" => [
                $new(new IntegerType()), 1, .5, \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects integer value, string given" => [
                $new(new IntegerType()), 1, 'two', \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects string value, float given" => [
                $new(new StringType()), 1, 1.9, \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects string value, integer given" => [
                $new(new StringType()), 1, 2, \InvalidArgumentException::class
            ],
        ];
    }

    private static function buildStringKeySetTests(\Closure $new, string $className): array {
        $prefix = 'String key set tests';
        return [
            "{$prefix} - {$className} set one to 2" => [
                $new(new IntegerType()), 'one', 2, null
            ],
            "{$prefix} - {$className} set one to two" => [
                $new(new StringType()), 'one', 'two', null
            ],
            "{$prefix} - {$className} set two to 1" => [
                $new(new IntegerType()), 'two', 1, null
            ],
            "{$prefix} - {$className} set two to one" => [
                $new(new StringType()), 'two', 'one', null
            ],
            "{$prefix} - {$className} set expects string key, float given" => [
                $new(new IntegerType()), .5, 1, \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects string key, integer given" => [
                $new(new IntegerType()), 1, 1, \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects integer value, float given" => [
                $new(new IntegerType()), 'one', .5, \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects integer value, string given" => [
                $new(new IntegerType()), 'one', 'one', \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects string value, float given" => [
                $new(new StringType()), 'one', 1.9, \InvalidArgumentException::class
            ],
            "{$prefix} - {$className} set expects string value, integer given" => [
                $new(new StringType()), 'one', 2, \InvalidArgumentException::class
            ],
        ];
    }

    /**
     * @dataProvider getCloneTests
     */
    public function testClone(Mapper $map, $cloneNewKey, $cloneNewValue): void
    {
        // Test fresh clone
        $clone = $map->clone();
        $this->assertNotSame($map, $clone, 'Map clone should be a new instance');
        $this->assertSame(
            $map->count(),
            $clone->count(),
            "Immediately after cloning, the count()'s are different"
        );
        $this->assertSame(
            $map->getKeyType(),
            $clone->getKeyType(),
            'Immediately after cloning, the key types are different.'
        );
        $this->assertSame(
            $map->getValueType(),
            $clone->getValueType(),
            'Immediately after cloning, the value types are different.'
        );

        // Modifying the clone should not modify the original
        $clone->set($cloneNewKey, $cloneNewValue);
        $this->assertFalse(
            $map->hasKey($cloneNewKey),
            'Modifying the cloned instance should not modify the original instance'
        );
    }

    public function getCloneTests(): array
    {
        return array_merge(
            // IntegerKeyHashMap
            self::buildCloneTest(new IntegerKeyHashMap(new IntegerType()), 9, 10),
            self::buildCloneTest(new IntegerKeyHashMap(new StringType()), 7, 'ipsum'),

            // StringKeyHashMap
            self::buildCloneTest(new StringKeyHashMap(new IntegerType()), 'ipsum', 8),
            self::buildCloneTest(new StringKeyHashMap(new StringType()), 'lorem', 'ipsum'),

            // HashMap
            self::buildCloneTest(new HashMap(new IntegerType(), new IntegerType()), 9, 10),
            self::buildCloneTest(new HashMap(new IntegerType(), new StringType()), 7, 'ipsum'),
            self::buildCloneTest(new HashMap(new StringType(), new IntegerType()), 'ipsum', 8),
            self::buildCloneTest(new HashMap(new StringType(), new StringType()), 'lorem', 'ipsum'),
        );
    }

    /**
     * @dataProvider getCountTestData
     */
    public function testCount(\Countable $countable, int $expected): void
    {
        $this->assertSame($expected, $countable->count());
    }

    public function getCountTestData(): array
    {
        return array_merge(
            self::buildCountTest(new IntegerKeyHashMap(new StringType()), 0),
            self::buildCountTest((new IntegerKeyHashMap(new StringType()))->set(0, 'foobar')->set(5, 'lorem'), 2),
            self::buildCountTest(new StringKeyHashMap(new IntegerType()), 0),
            self::buildCountTest((new StringKeyHashMap(new IntegerType()))->set('lorem', 2)->set('ipsum', 7), 2),
            self::buildCountTest(new HashMap(new IntegerType(), new StringType()), 0),
            self::buildCountTest((new HashMap(new IntegerType(), new StringType()))->set(0, 'foobar')->set(5, 'lorem'), 2),
        );
    }

    /**
     * @dataProvider getGetKeyTypeTests
     */
    public function testGetKeyType(Mapper $map, Type $expectedType): void
    {
        $mapType = new ClassType(get_class($map->getKeyType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Mapper->getKeyType() returned the wrong type');
    }

    public function getGetKeyTypeTests(): array
    {
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
    public function testGetValueType(Mapper $map, Type $expectedType): void
    {
        $mapType = new ClassType(get_class($map->getValueType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Mapper->getValueType() returned the wrong type');
    }

    public function getGetValueTypeTests(): array
    {
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
    public function testHasKey(Mapper $map, $key, bool $expected): void
    {
        $this->assertSame($expected, $map->hasKey($key));
    }

    public function getHasKeyTests(): array
    {
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

    public static function buildHasKeyTest(Mapper $map, $key, bool $expected): array
    {
        return [
            get_class($map) . '->hasKey() returns ' . ($expected ? 'true' : 'false') . ' for key ' . $key => [
                $map, $key, $expected,
            ],
        ];
    }

    /**
     * @dataProvider getThrowsExceptionTestData
     */
    public function testThrowsException(\Closure $closure, string $expectedExceptionClassName): void
    {
        (new ThrowsExceptionTestHelper($this))->test($closure, $expectedExceptionClassName);
    }

    public function getThrowsExceptionTestData(): array
    {
        return [

            // HashMap->__construct() with invalid key type
            'New ' . HashMap::class . ' with keyType of ArrayType' => [
                static function (): void {
                    new HashMap(new ArrayType(), new ArrayType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . HashMap::class . ' with keyType of BooleanType' => [
                static function (): void {
                    new HashMap(new BooleanType(), new BooleanType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . HashMap::class . ' with keyType of ClassType' => [
                static function (): void {
                    new HashMap(new ClassType(\Exception::class), new ClassType(\Exception::class));
                },
                \InvalidArgumentException::class,
            ],
            'New ' . HashMap::class . ' with keyType of FloatType' => [
                static function (): void {
                    new HashMap(new FloatType(), new FloatType());
                },
                \InvalidArgumentException::class,
            ],
            'New ' . HashMap::class . ' with keyType of InterfaceType' => [
                static function (): void {
                    new HashMap(new InterfaceType(\Throwable::class), new InterfaceType(\Throwable::class));
                },
                \InvalidArgumentException::class,
            ],

            // HashMap->get()
            HashMap::class . '->get() expects integer key, passed string' => [
                static function (): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->get('string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->get() expects string key, passed integer' => [
                static function (): void {
                    (new HashMap(new StringType(), new StringType()))->get(1);
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->get(); key does not exist' => [
                static function (): void {
                    (new HashMap(new IntegerType(), new IntegerType()))
                        ->set(1, 2)
                        ->get(5);
                },
                \OutOfBoundsException::class,
            ],
            HashMap::class . '->get() should throw exception after the key was removed' => [
                static function (): void {
                    (new HashMap(new IntegerType(), new IntegerType()))
                        ->set(1, 2)
                        ->removeKey(1)
                        ->get(1);
                },
                \OutOfBoundsException::class,
            ],

            // HashMap->hasKey()
            HashMap::class . '->hasKey() expects integer key, passed string' => [
                static function (): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->hasKey('string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->hasKey() expects string key, passed integer' => [
                static function (): void {
                    (new HashMap(new StringType(), new StringType()))->hasKey(1);
                },
                \InvalidArgumentException::class,
            ],

            // HashMap->removeKey()
            HashMap::class . '->removeKey() expects integer key, passed string' => [
                static function (): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->removeKey('string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->removeKey() expects string key, passed integer' => [
                static function (): void {
                    (new HashMap(new StringType(), new StringType()))->removeKey(1);
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->removeKey(); key does not exist' => [
                static function (): void {
                    (new HashMap(new IntegerType(), new IntegerType()))
                        ->set(1, 2)
                        ->removeKey(5);
                },
                \OutOfBoundsException::class,
            ],
        ];
    }

    private static function buildCountTest(\Countable $countable, int $expected): array
    {
        return [
            get_class($countable) . "->count() should return {$expected}" => [$countable, $expected],
        ];
    }

    private static function buildCloneTest(Mapper $map, $cloneNewKey, $cloneNewValue): array
    {
        $cloneDescription = "clone->set({$cloneNewKey}, {$cloneNewValue})";
        return [
            get_class($map) . "->clone(); {$cloneDescription}" => [
                $map, $cloneNewKey, $cloneNewValue,
            ],
        ];
    }
}
