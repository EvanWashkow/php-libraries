<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\TypeInterface\NameableTypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests Types that implement NameableTypeInterface.
 *
 * @internal
 * @coversNothing
 */
final class NameableTypeTest extends TestCase
{
    /**
     * @dataProvider getNameTestData
     */
    public function testGetName(NameableTypeInterface $type, string $expected): void
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
