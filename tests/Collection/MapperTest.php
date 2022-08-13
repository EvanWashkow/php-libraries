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
    public function testAccessors(Mapper $map, $key, $expected): void {
        $this->assertSame($expected, $map->get($key));
    }

    public function getAccessorTests(): array {
        return array_merge(
            self::buildAccessorTestsForIntKeyIntValueMap(new IntegerKeyHashMap(new IntegerType())),
            self::buildAccessorTestsForStringKeyStringValueMap(new StringKeyHashMap(new StringType())),
            self::buildAccessorTestsForIntKeyIntValueMap(new HashMap(new IntegerType(), new IntegerType())),
            self::buildAccessorTestsForStringKeyStringValueMap(new HashMap(new StringType(), new StringType())),
        );
    }

    /**
     * Builds Mapper accessor tests for Maps with integer keys and values
     *
     * @param Mapper $map The map
     */
    private static function buildAccessorTestsForIntKeyIntValueMap(Mapper $map): array {
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
    private static function buildAccessorTestsForStringKeyStringValueMap(Mapper $map): array {
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

    /**
     * @dataProvider getCloneTests
     */
    public function testClone(Mapper $original, $originalNewKey, $originalNewValue, $cloneNewKey, $cloneNewValue): void {
        // Test fresh clone
        $clone = $original->clone();
        $this->assertSame(
            $original->count(),
            $clone->count(),
            "Immediately after cloning, the count()'s are different"
        );
        $this->assertSame(
            $original->getKeyType(),
            $clone->getKeyType(),
            "Immediately after cloning, the key types are different."
        );
        $this->assertSame(
            $original->getValueType(),
            $clone->getValueType(),
            "Immediately after cloning, the value types are different."
        );

        // Modify the original and test that it does not modify the clone
        $original->set($originalNewKey, $originalNewValue);
        $this->assertFalse(
            $clone->hasKey($originalNewKey),
            "Modifying the original instance should not modify the cloned instance"
        );

        // Modify the clone and test that it does not modify the original
        $clone->set($cloneNewKey, $cloneNewValue);
        $this->assertFalse(
            $original->hasKey($cloneNewKey),
            "Modifying the cloned instance should not modify the original instance"
        );
    }

    public function getCloneTests(): array {
        return array_merge(
            // IntegerKeyHashMap
            self::buildCloneTest(new IntegerKeyHashMap(new IntegerType()), 11, 12, 9, 10),
            self::buildCloneTest(new IntegerKeyHashMap(new StringType()), 3, 'lorem', 7, 'ipsum'),

            // StringKeyHashMap
            self::buildCloneTest(new StringKeyHashMap(new IntegerType()), 'lorem', 4, 'ipsum', 8),
            self::buildCloneTest(new StringKeyHashMap(new StringType()), 'foo', 'bar', 'lorem', 'ipsum'),

            // HashMap
            self::buildCloneTest(new HashMap(new IntegerType(), new IntegerType()), 11, 12, 9, 10),
            self::buildCloneTest(new HashMap(new IntegerType(), new StringType()), 3, 'lorem', 7, 'ipsum'),
            self::buildCloneTest(new HashMap(new StringType(), new IntegerType()), 'lorem', 4, 'ipsum', 8),
            self::buildCloneTest(new HashMap(new StringType(), new StringType()), 'foo', 'bar', 'lorem', 'ipsum'),
        );
    }

    private static function buildCloneTest(Mapper $original, $originalNewKey, $originalNewValue, $cloneNewKey, $cloneNewValue): array {
        $cloneDescription = "clone->set({$cloneNewKey}, {$cloneNewValue})";
        $originalDescription = "original->set({$originalNewKey}, {$originalNewValue})";
        return [
            get_class($original) . "->clone(); {$originalDescription}; {$cloneDescription}" => [
                $original, $originalNewKey, $originalNewValue, $cloneNewKey, $cloneNewValue,
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

    /**
     * @dataProvider getThrowsExceptionTestData
     */
    public function testThrowsException(\Closure $closure, string $expectedExceptionClassName): void {
        (new ThrowsExceptionTestHelper($this))->test($closure, $expectedExceptionClassName);
    }

    public function getThrowsExceptionTestData(): array {
        return [

            // HashMap->__construct() with invalid key type
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

            // HashMap->get()
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

            // HashMap->hasKey()
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

            // HashMap->removeKey()
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

            // HashMap->set()
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
