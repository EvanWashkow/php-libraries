<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\TypeInterface;

use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\TypeInterface\InheritableType;
use EvanWashkow\PHPLibraries\TypeInterface\NameableType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;
use PHPUnit\Framework\TestCase;

/**
 * Tests Type interfaces.
 *
 * @internal
 *
 * @coversNothing
 */
final class TypeTest extends TestCase
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
            Type::class => [Type::class, Equatable::class],
            InheritableType::class => [InheritableType::class, Type::class],
            NameableType::class => [NameableType::class, Type::class],
        ];
    }
}
