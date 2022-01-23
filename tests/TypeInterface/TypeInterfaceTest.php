<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\TypeInterface;

use EvanWashkow\PHPLibraries\EquatableInterface;
use EvanWashkow\PHPLibraries\TypeInterface\InheritableTypeInterface;
use EvanWashkow\PHPLibraries\TypeInterface\NameableTypeInterface;
use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests Type interfaces.
 *
 * @internal
 * @coversNothing
 */
final class TypeInterfaceTest extends TestCase
{
    /**
     * @dataProvider getTestData
     *
     * @param mixed $interface
     * @param mixed $expectedParent
     */
    public function test($interface, $expectedParent): void
    {
        $interfaceReflection = new \ReflectionClass($interface);
        $expectedReflection = new \ReflectionClass($expectedParent);
        $this->assertTrue(
            $interfaceReflection->isSubclassOf($expectedReflection),
            "{$interface} does not derive from {$expectedParent}"
        );
    }

    public function getTestData(): array
    {
        return [
            TypeInterface::class => [TypeInterface::class, EquatableInterface::class],
            InheritableTypeInterface::class => [InheritableTypeInterface::class, TypeInterface::class],
            NameableTypeInterface::class => [NameableTypeInterface::class, TypeInterface::class],
        ];
    }
}
