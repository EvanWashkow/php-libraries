<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Type;

use EvanWashkow\PhpLibraries\Tests\TestDefinition\EquatableInterface\AbstractEquatableTestCase;
use EvanWashkow\PhpLibraries\Tests\TestDefinition\EquatableInterface\EquatableTestBuilder;
use EvanWashkow\PhpLibraries\Type\ArrayType;
use EvanWashkow\PhpLibraries\Type\BooleanType;
use EvanWashkow\PhpLibraries\Type\ClassType;
use EvanWashkow\PhpLibraries\Type\FloatType;
use EvanWashkow\PhpLibraries\Type\IntegerType;
use EvanWashkow\PhpLibraries\Type\InterfaceType;
use EvanWashkow\PhpLibraries\Type\StringType;
use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * Tests Types' EquatableInterface implementation.
 *
 * @internal
 *
 * @coversNothing
 */
final class TypeEquatableTest extends AbstractEquatableTestCase
{
    public function getEqualsTestData(): array
    {
        $classType = ClassType::class;
        $interfaceType = InterfaceType::class;

        return array_merge(
            $this->newTestBuilder(ArrayType::class, new ArrayType())->build(),
            $this->newTestBuilder(BooleanType::class, new BooleanType())->build(),
            $this->newTestBuilder(FloatType::class, new FloatType())->build(),
            $this->newTestBuilder(IntegerType::class, new IntegerType())->build(),
            $this->newTestBuilder(StringType::class, new StringType())->build(),
            $this->newTestBuilder("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->notEquals("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->notEquals("{$classType}(StubClassC)", new ClassType(StubClassC::class))
                ->build(),
            $this->newTestBuilder("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->notEquals("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->notEquals("{$classType}(StubClassC)", new ClassType(StubClassC::class))
                ->build(),
            $this->newTestBuilder("{$classType}(StubClassC)", new ClassType(StubClassC::class))
                ->notEquals("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->notEquals("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->build(),
            $this->newTestBuilder("{$interfaceType}(StubInterfaceA)", new InterfaceType(StubInterfaceA::class))
                ->notEquals("{$interfaceType}(StubInterfaceB)", new InterfaceType(StubInterfaceB::class))
                ->notEquals("{$interfaceType}(StubInterfaceC)", new InterfaceType(StubInterfaceC::class))
                ->build(),
            $this->newTestBuilder("{$interfaceType}(StubInterfaceB)", new InterfaceType(StubInterfaceB::class))
                ->notEquals("{$interfaceType}(StubInterfaceA)", new InterfaceType(StubInterfaceA::class))
                ->notEquals("{$interfaceType}(StubInterfaceC)", new InterfaceType(StubInterfaceC::class))
                ->build(),
            $this->newTestBuilder("{$interfaceType}(StubInterfaceC)", new InterfaceType(StubInterfaceC::class))
                ->notEquals("{$interfaceType}(StubInterfaceA)", new InterfaceType(StubInterfaceA::class))
                ->notEquals("{$interfaceType}(StubInterfaceB)", new InterfaceType(StubInterfaceB::class))
                ->build(),
        );
    }

    private function newTestBuilder(string $testHeader, Type $type): EquatableTestBuilder
    {
        return (new EquatableTestBuilder($testHeader, $type))
            ->equals('clone', clone $type)
            ->notEquals('TypeInterface mock', $this->createMock(Type::class))
        ;
    }
}
