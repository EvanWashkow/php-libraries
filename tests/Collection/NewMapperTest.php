<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Collection;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Collection\IntegerKeyHashMap;
use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;
use PHPUnit\Framework\TestCase;

final class NewMapperTest extends TestCase
{
    /**
     * @dataProvider getStateTransitionTests
     *
     * @param Mapper $map
     * @param $key
     * @param $value
     * @param bool $isNewKey
     * @param array $remainingKeys
     * @return void
     */
    public function testStateTransition(Mapper $map, $key, $value, bool $isNewKey, array $remainingKeys): void
    {
        // Test clone initial state
        $clone = $map->clone();
        $this->assertNotSame($map, $clone, 'clone() did not return a unique map instance');

        // Test state after set()
        $previousCount = $map->count();
        $returnedMap = $map->set($key, $value);
        $this->assertSame($map, $returnedMap, 'set() did not return the same map instance');
        $this->assertSame(
            $previousCount + ($isNewKey ? 1 : 0),
            $map->count(),
            'set() did not increment count()'
        );
        $this->assertTrue($map->hasKey($key), 'hasKey() did not return true after the key was set');
        $this->assertSame($value, $map->get($key), 'get() did not return the set value');

        // Test clone after setting new key and value on original
        if ($isNewKey) {
            $this->assertFalse($clone->hasKey($key), 'modifying original should not modify clone');
        } else {
            $this->assertNotSame(
                $value,
                $clone->get($key),
                'modifying original should not modify clone'
            );
        }

        // Test state after removeKey()
        $previousCount = $map->count();
        $returnedMap = $map->removeKey($key);
        $this->assertSame($map, $returnedMap, 'removeKey() did not return the same map instance');
        $this->assertSame(
            $previousCount - 1,
            $map->count(),
            'removeKey() did not decrement count()'
        );
        $this->assertFalse($map->hasKey($key), 'hasKey() did not return false after the key was removed');
        $this->assertThrows(
            static function () use ($map, $key): void {
                $map->get($key);
            },
            \OutOfBoundsException::class,
            'get() did not throw an OutOfBoundsException for a missing key'
        );
        $this->assertThrows(
            static function () use ($map, $key): void {
                $map->removeKey($key);
            },
            \OutOfBoundsException::class,
            'removeKey() did not throw an OutOfBoundsException for a missing key'
        );

        // Test clone after removing key from original
        $clone->set($key, $value);
        $this->assertFalse($map->hasKey($key), 'modifying clone should not modify original');

        // Test remaining keys after remove
        foreach ($remainingKeys as $remainingKey) {
            $this->assertTrue($map->hasKey($remainingKey), 'map does not have remaining key');
        }
    }

    public function getStateTransitionTests(): array
    {
        return array_merge(
            self::buildIntegerKeyTests(
                static function (Type $type) {
                    return new IntegerKeyHashMap($type);
                },
                IntegerKeyHashMap::class
            ),
            self::buildIntegerKeyTests(
                static function (Type $type) {
                    return new HashMap(new IntegerType(), $type);
                },
                HashMap::class
            ),
        );
    }

    private function assertThrows(\Closure $func, string $wantException, ?string $message = null): void
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

    private static function buildIntegerKeyTests(\Closure $new, string $className): array
    {
        $prefix = 'Integer key set tests';
        return [
            "{$prefix} - {$className} set and remove a new entry with a different value (1 => 2)" => [
                $new(new IntegerType()), 1, 2, true, [],
            ],
            "{$prefix} - {$className} set and remove a new entry with a different value (1 => six)" => [
                $new(new StringType()), 1, 'six', true, [],
            ],
            "{$prefix} - {$className} set and remove a new entry with a different key (2 => 5)" => [
                $new(new IntegerType()), 2, 5, true, [],
            ],
            "{$prefix} - {$className} set and remove a new entry with a different key (2 => one)" => [
                $new(new StringType()), 2, 'one', true, [],
            ],
            "{$prefix} - {$className} override a value at a key (3 => 7)" => [
                $new(new IntegerType())->set(3, 0), 3, 7, false, [],
            ],
            "{$prefix} - {$className} add a new entry to others (4 => nine)" => [
                $new(new StringType())->set(6, 'lorem')->set(1, 'ipsum'), 4, 'nine', true, [6, 1],
            ],
        ];
    }

    private static function buildStringKeyTests(\Closure $new, string $className): array
    {
        $prefix = 'String key set tests';
        return [
            "{$prefix} - {$className} set one to 2" => [
                $new(new IntegerType()), 'one', 2, true,
            ],
            "{$prefix} - {$className} set one to two" => [
                $new(new StringType()), 'one', 'two', true,
            ],
            "{$prefix} - {$className} set two to 1" => [
                $new(new IntegerType()), 'two', 1, true,
            ],
            "{$prefix} - {$className} set two to one" => [
                $new(new StringType()), 'two', 'one', true,
            ],
        ];
    }
}
