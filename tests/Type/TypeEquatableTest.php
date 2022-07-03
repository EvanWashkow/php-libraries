<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Tests\TestDefinition\EquatableInterface\AbstractEquatableInterfaceTestCase;
use EvanWashkow\PHPLibraries\Tests\TestDefinition\EquatableInterface\EquatableInterfaceTestBuilder;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\FloatType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * Tests Types' EquatableInterface implementation.
 *
 * @internal
 *
 * @coversNothing
 */
final class TypeEquatableTest extends AbstractEquatableInterfaceTestCase
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

    private function newTestBuilder(string $testHeader, TypeInterface $type): EquatableInterfaceTestBuilder
    {
        return (new EquatableInterfaceTestBuilder($testHeader, $type))
            ->equals('clone', clone $type)
            ->notEquals('TypeInterface mock', $this->createMock(TypeInterface::class))
        ;
    }
}
