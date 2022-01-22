<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests Types
 */
final class OldTypeTest extends TestCase
{
    /**
     * @dataProvider getIsTestData
     */
    public function testIs(TypeInterface $tester, TypeInterface $testee, bool $expected): void
    {
        $this->assertSame($expected, $tester->is($testee));
    }

    public function getIsTestData(): array
    {
        $data = [];
        foreach ($this->getTestBuilders() as $builder) {
            $data = array_merge($data, $builder->buildIsTestData());
        }
        return $data;
    }


    /**
     * Retrieves the TypeTestDataBuilders
     *
     * @return array<TypeTestDataBuilder>
     */
    public function getTestBuilders(): array
    {
        $classType = ClassType::class;
        $interfaceType = InterfaceType::class;

        return [
            $this->newTestBuilder("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->notIs('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class)),
            $this->newTestBuilder("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->is('StubClassA', new ClassType(StubClassA::class))
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->is('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class)),

            $this->newTestBuilder("{$interfaceType}(StubInterfaceA)", new InterfaceType(StubInterfaceA::class))
                ->notIs('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassA', new ClassType(StubClassA::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class)),
            $this->newTestBuilder("{$interfaceType}(StubInterfaceB)", new InterfaceType(StubInterfaceB::class))
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassA', new ClassType(StubClassA::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class)),
        ];
    }


    /**
     * Creates a new default TypeTestDataBuilder
     */
    private function newTestBuilder(string $testName, TypeInterface $type): TypeTestDataBuilder
    {
        return (new TypeTestDataBuilder($testName, $type))
            ->notIs('Type mock', $this->createMock(TypeInterface::class));
    }
}