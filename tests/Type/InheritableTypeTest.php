<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\TypeInterface\InheritableTypeInterface;
use EvanWashkow\PHPLibraries\TypeInterface\NameableTypeInterface;
use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests InheritableTypes.
 *
 * @internal
 * @coversNothing
 */
final class InheritableTypeTest extends TestCase
{
    /**
     * @dataProvider getIsTestData
     */
    public function testIs(InheritableTypeInterface $tester, TypeInterface $testee, bool $expected): void
    {
        $this->assertSame($expected, $tester->is($testee));
    }

    public function getIsTestData(): array
    {
        $classType = ClassType::class;
        $interfaceType = InterfaceType::class;

        return array_merge(
            $this->newTestBuilder("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->notIs('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class))
                ->build(),
            $this->newTestBuilder("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->is('StubClassA', new ClassType(StubClassA::class))
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->is('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class))
                ->build(),
            $this->newTestBuilder("{$interfaceType}(StubInterfaceA)", new InterfaceType(StubInterfaceA::class))
                ->notIs('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassA', new ClassType(StubClassA::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class))
                ->build(),
            $this->newTestBuilder("{$interfaceType}(StubInterfaceB)", new InterfaceType(StubInterfaceB::class))
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->is(
                    'StubbedNameableType(StubInterfaceA)',
                    (function () {
                        $mock = $this->createStub(NameableTypeInterface::class);
                        $mock->method('getName')->willReturn(StubInterfaceA::class);

                        return $mock;
                    })()
                )
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassA', new ClassType(StubClassA::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class))
                ->build(),
        );
    }

    /**
     * Creates a new default TypeTestDataBuilder.
     */
    private function newTestBuilder(string $testName, TypeInterface $type): InheritableTypeTestDataBuilder
    {
        return (new InheritableTypeTestDataBuilder($testName, $type))
            ->notIs('Type mock', $this->createMock(TypeInterface::class))
        ;
    }
}
