<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Tests\EquatableInterface\AbstractEquatableTestDefinition;
use EvanWashkow\PHPLibraries\Tests\EquatableInterface\EquatableTestDataBuilder;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\FloatType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\Type\TypeInterface;

final class TypeEqualsTest extends AbstractEquatableTestDefinition
{
    public function getTestData(): array
    {
        $classType = ClassType::class;

        return array_merge(
            $this->newDefaultTestDataBuilder(ArrayType::class, new ArrayType())->build(),
            $this->newDefaultTestDataBuilder(BooleanType::class, new BooleanType())->build(),
            $this->newDefaultTestDataBuilder(FloatType::class, new FloatType())->build(),
            $this->newDefaultTestDataBuilder(IntegerType::class, new IntegerType())->build(),
            $this->newDefaultTestDataBuilder(StringType::class, new StringType())->build(),

            $this->newDefaultTestDataBuilder("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->notEquals("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->notEquals("{$classType}(StubClassC)", new ClassType(StubClassC::class))
                ->build(),
            $this->newDefaultTestDataBuilder("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->notEquals("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->notEquals("{$classType}(StubClassC)", new ClassType(StubClassC::class))
                ->build(),
            $this->newDefaultTestDataBuilder("{$classType}(StubClassC)", new ClassType(StubClassC::class))
                ->notEquals("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->notEquals("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->build(),
        );
    }


    private function newDefaultTestDataBuilder(string $testNamePrefix, TypeInterface $type): EquatableTestDataBuilder
    {
        return (new EquatableTestDataBuilder($testNamePrefix, $type))
            ->equals('clone', clone $type)
            ->notEquals('TypeInterface mock', $this->createMock(TypeInterface::class))
            ->notEquals('integer', 1)
            ->notEquals('bool', false)
            ->notEquals('string', 'string')
            ->notEquals('float', 3.1415)
            ->notEquals('array', []);
    }
}
