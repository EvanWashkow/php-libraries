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
     * Tests accessor methods, like get(), set(), add(), and etc.
     *
     * @dataProvider getAccessorTests
     */
    public function testAccessors(Mapper $map, $key, $expected): void
    {
        $this->assertSame($expected, $map->get($key));
    }

    public function getAccessorTests(): array
    {
        return array_merge(
            self::buildAccessorTestsForIntKeyIntValueMap(new IntegerKeyHashMap(new IntegerType())),
            self::buildAccessorTestsForStringKeyStringValueMap(new StringKeyHashMap(new StringType())),
            self::buildAccessorTestsForIntKeyIntValueMap(new HashMap(new IntegerType(), new IntegerType())),
            self::buildAccessorTestsForStringKeyStringValueMap(new HashMap(new StringType(), new StringType())),
        );
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

            // HashMap->set()
            HashMap::class . '->set() expects integer key, passed string' => [
                static function (): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->set('string', 1);
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->set() expects string key, passed integer' => [
                static function (): void {
                    (new HashMap(new StringType(), new StringType()))->set(1, 'string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->set() expects integer value, passed string' => [
                static function (): void {
                    (new HashMap(new IntegerType(), new IntegerType()))->set(1, 'string');
                },
                \InvalidArgumentException::class,
            ],
            HashMap::class . '->set() expects string value, passed integer' => [
                static function (): void {
                    (new HashMap(new StringType(), new StringType()))->set('string', 1);
                },
                \InvalidArgumentException::class,
            ],
        ];
    }

    private static function buildCountTest(\Countable $countable, int $expected): array
    {
        return [
            get_class($countable) . "->count() should return {$expected}" => [$countable, $expected],
        ];
    }

    /**
     * Builds Mapper accessor tests for Maps with integer keys and values
     *
     * @param Mapper $map The map
     */
    private static function buildAccessorTestsForIntKeyIntValueMap(Mapper $map): array
    {
        $className = get_class($map);
        return [
            "{$className}->set(PHP_INT_MIN, PHP_INT_MAX)->get(PHP_INT_MIN) should return PHP_INT_MAX" => [
                $map->clone()->set(PHP_INT_MIN, PHP_INT_MAX),
                PHP_INT_MIN,
                PHP_INT_MAX,
            ],
            "{$className}->set(PHP_INT_MAX, PHP_INT_MIN)->get(PHP_INT_MAX) should return PHP_INT_MIN" => [
                $map->clone()->set(PHP_INT_MAX, PHP_INT_MIN),
                PHP_INT_MAX,
                PHP_INT_MIN,
            ],
            "{$className}->set(0, 0)->set(0, 5)->get(0) should return 5" => [
                $map->clone()->set(0, 0)->set(0, 5),
                0,
                5,
            ],
        ];
    }

    /**
     * Builds Mapper accessor tests for Maps with string keys and values
     *
     * @param Mapper $map The map
     */
    private static function buildAccessorTestsForStringKeyStringValueMap(Mapper $map): array
    {
        $className = get_class($map);
        return [
            "{$className}->set('foo', 'bar')->get('foo') should return 'bar'" => [
                $map->clone()->set('foo', 'bar'),
                'foo',
                'bar',
            ],
            "{$className}->set('bar', 'foo')->get('bar') should return 'foo'" => [
                $map->clone()->set('bar', 'foo'),
                'bar',
                'foo',
            ],
            "{$className}->set('lorem', 'foobar')->set('lorem', 'ipsum')->get('lorem') should return 'ipsum'" => [
                $map->clone()->set('lorem', 'foobar')->set('lorem', 'ipsum'),
                'lorem',
                'ipsum',
            ],
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
