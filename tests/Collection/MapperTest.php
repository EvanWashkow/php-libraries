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
use function Symfony\Component\String\s;

final class MapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getCloneTests
     */
    public function testClone(Mapper $map, $key, $value): void
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

        // Modifying the original should not modify the clone
        $map->set($key, $value);
        $this->assertFalse(
            $clone->hasKey($key),
            'Modifying the original should not modify the clone'
        );
        $map->removeKey($key);

        // Modifying the clone should not modify the original
        $clone->set($key, $value);
        $this->assertFalse(
            $map->hasKey($key),
            'Modifying the clone should not modify the original'
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
     * @dataProvider getCountTests
     */
    public function testCount(\Countable $countable, int $expected): void
    {
        $this->assertSame($expected, $countable->count());
    }

    public function getCountTests(): array
    {
        return array_merge(
            self::buildCountTestForIntegerKey(
                static function (Type $valueType) {
                    return new IntegerKeyHashMap($valueType);
                },
                IntegerKeyHashMap::class
            ),
            self::buildCountTestForStringKey(
                static function (Type $valueType) {
                    return new StringKeyHashMap($valueType);
                },
                StringKeyHashMap::class
            ),
            self::buildCountTestForIntegerKey(
                static function (Type $valueType) {
                    return new HashMap(new IntegerType(), $valueType);
                },
                HashMap::class
            ),
            self::buildCountTestForStringKey(
                static function (Type $valueType) {
                    return new HashMap(new StringType(), $valueType);
                },
                HashMap::class
            ),
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
            IntegerKeyHashMap::class . ' value type should return ' . StringType::class => [
                new IntegerKeyHashMap(new StringType()), new StringType(),
            ],
            StringKeyHashMap::class . ' value type should return ' . IntegerType::class => [
                new StringKeyHashMap(new IntegerType()), new IntegerType(),
            ],
            StringKeyHashMap::class . ' value type should return ' . FloatType::class => [
                new StringKeyHashMap(new FloatType()), new FloatType(),
            ],
            HashMap::class . ' with ' . ArrayType::class . ' value type should return that type' => [
                new HashMap(new IntegerType(), new ArrayType()), new ArrayType(),
            ],
            HashMap::class . ' with ' . IntegerType::class . ' value type should return that type' => [
                new HashMap(new IntegerType(), new IntegerType()), new IntegerType(),
            ],
            HashMap::class . ' with ' . BooleanType::class . ' value type should return that type' => [
                new HashMap(new StringType(), new BooleanType()), new BooleanType(),
            ],
            HashMap::class . ' with ' . StringType::class . ' value type should return that type' => [
                new HashMap(new StringType(), new StringType()), new StringType(),
            ],
        ];
    }

    /**
     * @dataProvider getKeyAccessTests
     */
    public function testGet(Mapper $map, $key, $value, bool $hasKey): void
    {
        if ($hasKey) {
            $this->assertSame($value, $map->get($key), 'get() did not return the correct value');
        } else {
            $this->assertThrows(
                \OutOfBoundsException::class,
                static function () use ($map, $key): void {
                    $map->get($key);
                },
                'get() did not throw an OutOfBoundsException'
            );
        }
    }

    /**
     * @dataProvider getKeyAccessTests
     */
    public function testHasKey(Mapper $map, $key, $value, bool $hasKey): void
    {
        $this->assertSame($hasKey, $map->hasKey($key));
    }

    public function getKeyAccessTests(): array
    {
        return array_merge(
            self::buildKeyAccessTestForIntegerKey(
                static function (Type $valueType) {
                    return new IntegerKeyHashMap($valueType);
                },
                IntegerKeyHashMap::class
            ),
            self::buildKeyAccessTestForStringKey(
                static function (Type $valueType) {
                    return new StringKeyHashMap($valueType);
                },
                StringKeyHashMap::class
            ),

            // HashMap
            self::buildKeyAccessTestForIntegerKey(
                static function (Type $valueType) {
                    return new HashMap(new IntegerType(), $valueType);
                },
                HashMap::class
            ),
            self::buildKeyAccessTestForStringKey(
                static function (Type $valueType) {
                    return new HashMap(new StringType(), $valueType);
                },
                HashMap::class
            ),
        );
    }

    /**
     * @dataProvider getSetTests
     *
     * @param Mapper $map
     * @param $key
     * @param $value
     * @param string|null $wantException
     * @return void
     */
    public function testSet(Mapper $map, $key, $value, ?string $wantException): void
    {
        if ($wantException !== null) {
            $this->expectException($wantException);
        }
        $this->assertSame($value, $map->set($key, $value)->get($key), 'Map did not set the value');
    }

    public function getSetTests(): array
    {
        return array_merge(
            self::buildIntegerKeySetTests(
                static function (Type $type) {
                    return new IntegerKeyHashMap($type);
                },
                IntegerKeyHashMap::class
            ),
            self::buildStringKeySetTests(
                static function (Type $type) {
                    return new StringKeyHashMap($type);
                },
                StringKeyHashMap::class
            ),

            // HashMap
            self::buildIntegerKeySetTests(
                static function (Type $type) {
                    return new HashMap(new IntegerType(), $type);
                },
                HashMap::class
            ),
            self::buildStringKeySetTests(
                static function (Type $type) {
                    return new HashMap(new StringType(), $type);
                },
                HashMap::class
            ),
        );
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

    private function assertThrows(string $wantException, \Closure $func, ?string $message = null): void
    {
        $gotException = null;
        try {
            $func();
        } catch(\Throwable $t) {
            $gotException = $t;
        }
        if ($gotException === null) {
            $this->fail($message ?? 'no exception thrown');
        } else {
            $this->assertInstanceOf($wantException, $gotException, $message);
        }
    }

    private static function buildIntegerKeySetTests(\Closure $new, string $className): array
    {
        $prefix = 'Integer key set tests';
        return [
            "{$prefix} - {$className} set 1 to 2" => [
                $new(new IntegerType()), 1, 2, null,
            ],
            "{$prefix} - {$className} set 1 to two" => [
                $new(new StringType()), 1, 'two', null,
            ],
            "{$prefix} - {$className} set 2 to 1" => [
                $new(new IntegerType()), 2, 1, null,
            ],
            "{$prefix} - {$className} set 2 to one" => [
                $new(new StringType()), 2, 'one', null,
            ],
            "{$prefix} - {$className} set expects integer key, float given" => [
                $new(new IntegerType()), .5, 1, \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects integer key, string given" => [
                $new(new IntegerType()), 'one', 1, \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects integer value, float given" => [
                $new(new IntegerType()), 1, .5, \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects integer value, string given" => [
                $new(new IntegerType()), 1, 'two', \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects string value, float given" => [
                $new(new StringType()), 1, 1.9, \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects string value, integer given" => [
                $new(new StringType()), 1, 2, \InvalidArgumentException::class,
            ],
        ];
    }

    private static function buildStringKeySetTests(\Closure $new, string $className): array
    {
        $prefix = 'String key set tests';
        return [
            "{$prefix} - {$className} set one to 2" => [
                $new(new IntegerType()), 'one', 2, null,
            ],
            "{$prefix} - {$className} set one to two" => [
                $new(new StringType()), 'one', 'two', null,
            ],
            "{$prefix} - {$className} set two to 1" => [
                $new(new IntegerType()), 'two', 1, null,
            ],
            "{$prefix} - {$className} set two to one" => [
                $new(new StringType()), 'two', 'one', null,
            ],
            "{$prefix} - {$className} set expects string key, float given" => [
                $new(new IntegerType()), .5, 1, \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects string key, integer given" => [
                $new(new IntegerType()), 1, 1, \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects integer value, float given" => [
                $new(new IntegerType()), 'one', .5, \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects integer value, string given" => [
                $new(new IntegerType()), 'one', 'one', \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects string value, float given" => [
                $new(new StringType()), 'one', 1.9, \InvalidArgumentException::class,
            ],
            "{$prefix} - {$className} set expects string value, integer given" => [
                $new(new StringType()), 'one', 2, \InvalidArgumentException::class,
            ],
        ];
    }

    private static function buildKeyAccessTestForIntegerKey(\Closure $new, string $className): array
    {
        $prefix = 'Integer key test';
        return array_merge(
            self::buildKeyAccessTest(
                "{$prefix} {$className} - Empty should return false",
                $new(new StringType()),
                0,
                null,
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an existing key should return true",
                $new(new StringType())->set(1, 'lorem')->set(5, 'ipsum'),
                1,
                'lorem',
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an existing key should return true",
                $new(new StringType())->set(1, 'lorem')->set(5, 'ipsum'),
                5,
                'ipsum',
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an existing key should return true",
                $new(new StringType())->set(1, 'foo')->set(5, 'bar'),
                1,
                'foo',
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an existing key should return true",
                $new(new StringType())->set(1, 'foo')->set(5, 'bar'),
                5,
                'bar',
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an non-existent key should return false",
                $new(new StringType())->set(0, 'lorem')->set(5, 'ipsum'),
                6,
                null
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set()->set->remove() a removed key should return false",
                $new(new IntegerType())->set(0, 2)->set(5, 7)->set(10, 8)->removeKey(5),
                5,
                null
            ),
        );
    }

    private static function buildKeyAccessTestForStringKey(\Closure $new, string $className): array
    {
        $prefix = 'String key test';
        return array_merge(
            self::buildKeyAccessTest(
                "{$prefix} {$className} - Empty should return false",
                $new(new StringType()),
                'foobar',
                null
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an existing key should return true",
                $new(new StringType())->set('lorem', 'ipsum')->set('foo', 'bar'),
                'lorem',
                'ipsum'
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an existing key should return true",
                $new(new StringType())->set('lorem', 'ipsum')->set('foo', 'bar'),
                'foo',
                'bar'
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an existing key should return true",
                $new(new StringType())->set('lorem', 'foo')->set('bar', 'ipsum'),
                'lorem',
                'foo'
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an existing key should return true",
                $new(new StringType())->set('lorem', 'foo')->set('bar', 'ipsum'),
                'bar',
                'ipsum'
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set() - an non-existent key should return false",
                $new(new StringType())->set('lorem', 'ipsum')->set('foo', 'bar'),
                'dolor',
                null
            ),
            self::buildKeyAccessTest(
                "{$prefix} {$className}->set()->set()->set->remove() a removed key should return false",
                $new(new IntegerType())->set('lorem', 2)->set('ipsum', 7)->set('foobar', 8)->removeKey('ipsum'),
                'ipsum',
                null
            ),
        );
    }

    private static function buildKeyAccessTest(
        string $description,
        Mapper $map,
               $key,
               $value
    ): array {
        return [
            $description => [
                $map, $key, $value, $value !== null,
            ],
        ];
    }

    private static function buildCountTestForIntegerKey(\Closure $new, string $className): array
    {
        $prefix = 'Integer key test';
        return array_merge(
            self::buildCountTest(
                "{$prefix} {$className} - Empty should return 0",
                $new(new StringType()),
                0
            ),
            self::buildCountTest(
                "{$prefix} {$className}->set()->set() should return 2",
                $new(new StringType())->set(0, 'lorem')->set(5, 'ipsum'),
                2
            ),
            self::buildCountTest(
                "{$prefix} {$className}->set()->set()->set->remove() should return 2",
                $new(new IntegerType())->set(0, 2)->set(5, 7)->set(10, 8)->removeKey(5),
                2
            ),
        );
    }

    private static function buildCountTestForStringKey(\Closure $new, string $className): array
    {
        $prefix = 'String key test';
        return array_merge(
            self::buildCountTest(
                "{$prefix} {$className} - Empty should return 0",
                $new(new StringType()),
                0
            ),
            self::buildCountTest(
                "{$prefix} {$className}->set()->set() should return 2",
                $new(new IntegerType())->set('lorem', 2)->set('ipsum', 5),
                2
            ),
            self::buildCountTest(
                "{$prefix} {$className}->set()->set()->set->remove() should return 2",
                $new(new IntegerType())->set('lorem', 2)->set('ipsum', 7)->set('dolor', 8)->removeKey('ipsum'),
                2
            ),
        );
    }

    private static function buildCountTest(string $description, \Countable $countable, int $expected): array
    {
        return [
            $description => [$countable, $expected],
        ];
    }

    private static function buildCloneTest(Mapper $map, $key, $value): array
    {
        $cloneDescription = "clone->set({$key}, {$value})";
        return [
            get_class($map) . "->clone(); {$cloneDescription}" => [
                $map, $key, $value,
            ],
        ];
    }
}
