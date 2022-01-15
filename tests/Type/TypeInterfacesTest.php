<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\EquatableInterface;
use EvanWashkow\PHPLibraries\Type\NameableTypeInterface;
use EvanWashkow\PHPLibraries\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests Type interfaces.
 */
final class TypeInterfacesTest extends TestCase
{
    /**
     * @dataProvider getTestData
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
            NameableTypeInterface::class => [NameableTypeInterface::class, TypeInterface::class],
        ];
    }
}
