<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Collection;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Collection\IntegerKeyHashMap;
use EvanWashkow\PHPLibraries\Collection\StringKeyHashMap;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;

final class CountableTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getTestData
     */
    public function test(\Countable $countable, int $expected): void
    {
        $this->assertSame($expected, $countable->count());
    }

    public function getTestData(): array
    {
        return array_merge(
            $this->buildTest(new IntegerKeyHashMap(new StringType()), 0),
            $this->buildTest((new IntegerKeyHashMap(new StringType()))->set(0, 'foobar')->set(5, 'lorem'), 2),
            $this->buildTest(new StringKeyHashMap(new IntegerType()), 0),
            $this->buildTest((new StringKeyHashMap(new IntegerType()))->set('lorem', 2)->set('ipsum', 7), 2),
            $this->buildTest(new HashMap(new IntegerType(), new StringType()), 0),
            $this->buildTest((new HashMap(new IntegerType(), new StringType()))->set(0, 'foobar')->set(5, 'lorem'), 2),
        );
    }

    private function buildTest(\Countable $countable, int $expected): array
    {
        return [
            get_class($countable) . "->count() should return {$expected}" => [$countable, $expected],
        ];
    }
}
