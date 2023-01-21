<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests;

use EvanWashkow\PhpLibraries\Cloneable;
use EvanWashkow\PhpLibraries\Collection\HashMap;
use EvanWashkow\PhpLibraries\Collection\IntegerKeyHashMap;
use EvanWashkow\PhpLibraries\Collection\StringKeyHashMap;
use EvanWashkow\PhpLibraries\CollectionInterface\Collector;
use EvanWashkow\PhpLibraries\CollectionInterface\Mapper;
use EvanWashkow\PhpLibraries\Equatable;
use EvanWashkow\PhpLibraries\Type\ArrayType;
use EvanWashkow\PhpLibraries\Type\BooleanType;
use EvanWashkow\PhpLibraries\Type\ClassType;
use EvanWashkow\PhpLibraries\Type\FloatType;
use EvanWashkow\PhpLibraries\Type\IntegerType;
use EvanWashkow\PhpLibraries\Type\InterfaceType;
use EvanWashkow\PhpLibraries\Type\StringType;
use EvanWashkow\PhpLibraries\TypeInterface\InheritableType;
use EvanWashkow\PhpLibraries\TypeInterface\NameableType;
use EvanWashkow\PhpLibraries\TypeInterface\Type;

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
    public function test(Type $type, Type $expectedParent): void
    {
        $this->assertTrue(
            $type->is($expectedParent),
            "{$type->getName()} does not inherit {$expectedParent->getName()}"
        );
    }

    public function getTestData(): array
    {
        return array_merge(
            // CollectionInterface
            $this->buildTest(
                new InterfaceType(Collector::class),
                new InterfaceType(\Countable::class),
                new InterfaceType(Cloneable::class),
            ),
            $this->buildTest(
                new InterfaceType(Mapper::class),
                new InterfaceType(\Countable::class),
                new InterfaceType(Cloneable::class),
            ),

            // Collection
            $this->buildTest(new ClassType(HashMap::class), new InterfaceType(Mapper::class)),
            $this->buildTest(new ClassType(IntegerKeyHashMap::class), new InterfaceType(Mapper::class)),
            $this->buildTest(new ClassType(StringKeyHashMap::class), new InterfaceType(Mapper::class)),

            // TypeInterface
            $this->buildTest(new InterfaceType(Type::class), new InterfaceType(Equatable::class)),
            $this->buildTest(new InterfaceType(InheritableType::class), new InterfaceType(Type::class)),
            $this->buildTest(new InterfaceType(NameableType::class), new InterfaceType(Type::class)),

            // Type
            $this->buildTest(new ClassType(ArrayType::class), new InterfaceType(Type::class)),
            $this->buildTest(new ClassType(BooleanType::class), new InterfaceType(Type::class)),
            $this->buildTest(new ClassType(ClassType::class), new InterfaceType(InheritableType::class), new InterfaceType(NameableType::class)),
            $this->buildTest(new ClassType(FloatType::class), new InterfaceType(Type::class)),
            $this->buildTest(new ClassType(IntegerType::class), new InterfaceType(Type::class)),
            $this->buildTest(new ClassType(InterfaceType::class), new InterfaceType(InheritableType::class), new InterfaceType(NameableType::class)),
            $this->buildTest(new ClassType(StringType::class), new InterfaceType(Type::class)),
        );
    }

    /**
     * Build a new test entry
     *
     * @param ClassType|InterfaceType $type The type
     * @param ClassType|InterfaceType ...$expectedParents The type's expected parents
     */
    private function buildTest(Type $type, Type ...$expectedParents): array
    {
        $tests = [];
        foreach ($expectedParents as $expectedParent) {
            $tests["{$type->getName()} implements {$expectedParent->getName()}"] = [$type, $expectedParent];
        }
        return $tests;
    }
}
