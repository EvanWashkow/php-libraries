<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests;

use EvanWashkow\PHPLibraries\Collection\HashMap;
use EvanWashkow\PHPLibraries\Collection\IntegerKeyHashMap;
use EvanWashkow\PHPLibraries\Collection\StringKeyHashMap;
use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\TypeInterface\InheritableType;
use EvanWashkow\PHPLibraries\TypeInterface\NameableType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Tests type inheritance
 */
final class InheritanceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param ClassType|InterfaceType $type The type
     * @param ClassType|InterfaceType $expectedParent The type's expected parent
     *
     * @dataProvider getTestData
     */
    public function test(Type $type, Type $expectedParent): void {
        $this->assertTrue(
            $type->is($expectedParent),
            "{$type->getName()} does not inherit {$expectedParent->getName()}"
        );
    }

    public function getTestData(): array {
        return array_merge(
            // Collection
            $this->buildTest(new ClassType(HashMap::class), new InterfaceType(Mapper::class)),
            $this->buildTest(new ClassType(IntegerKeyHashMap::class), new InterfaceType(Mapper::class)),
            $this->buildTest(new ClassType(StringKeyHashMap::class), new InterfaceType(Mapper::class)),

            // CollectionInterface
            $this->buildTest(new InterfaceType(Mapper::class), new InterfaceType(\Countable::class)),

            // TypeInterface
            $this->buildTest(new InterfaceType(Type::class), new InterfaceType(Equatable::class)),
            $this->buildTest(new InterfaceType(InheritableType::class), new InterfaceType(Type::class)),
            $this->buildTest(new InterfaceType(NameableType::class), new InterfaceType(Type::class)),
        );
    }

    /**
     * Build a new test entry
     *
     * @param ClassType|InterfaceType $type The type
     * @param ClassType|InterfaceType ...$expectedParents The type's expected parents
     */
    private function buildTest(Type $type, Type ...$expectedParents): array {
        $tests = [];
        foreach ($expectedParents as $expectedParent) {
            $tests["{$type->getName()} implements {$expectedParent->getName()}"] = [$type, $expectedParent];
        }
        return $tests;
    }
}
