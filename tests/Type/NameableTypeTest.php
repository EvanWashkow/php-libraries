<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Type;

use EvanWashkow\PhpLibraries\Type\ClassType;
use EvanWashkow\PhpLibraries\Type\InterfaceType;
use EvanWashkow\PhpLibraries\TypeInterface\NameableType;
use PHPUnit\Framework\TestCase;

/**
 * Tests Types that implement NameableTypeInterface.
 *
 * @internal
 *
 * @coversNothing
 */
final class NameableTypeTest extends TestCase
{
    /**
     * @dataProvider getNameTestData
     */
    public function testGetName(NameableType $type, string $expected): void
    {
        $this->assertSame($expected, $type->getName());
    }

    public function getNameTestData(): array
    {
        return [
            'ClassType(StubClassA)' => [new ClassType(StubClassA::class), StubClassA::class],
            'ClassType(StubClassB)' => [new ClassType(StubClassB::class), StubClassB::class],
            'ClassType(StubClassC)' => [new ClassType(StubClassC::class), StubClassC::class],
            'InterfaceType(StubInterfaceA)' => [new InterfaceType(StubInterfaceA::class), StubInterfaceA::class],
            'InterfaceType(StubInterfaceB)' => [new InterfaceType(StubInterfaceB::class), StubInterfaceB::class],
            'InterfaceType(StubInterfaceC)' => [new InterfaceType(StubInterfaceC::class), StubInterfaceC::class],
        ];
    }
}
