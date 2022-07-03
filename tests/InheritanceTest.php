<?php

namespace EvanWashkow\PHPLibraries\Tests;

use EvanWashkow\PHPLibraries\Type\ClassInterfaceType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\TypeInterface\InheritableType;
use EvanWashkow\PHPLibraries\TypeInterface\NameableType;

final class InheritanceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getInheritanceTestData
     *
     * @param string $type
     * @param string $expectedParentType
     * @return void
     */
    public function testInheritance(string $type, string $expectedParentType) {
        $refType = new \ReflectionClass($type);
        $refParent = new \ReflectionClass($expectedParentType);
        $this->assertTrue($refType->isSubclassOf($refParent), "{$type} is not derived from {$expectedParentType}");
    }

    public function getInheritanceTestData(): array {
        return array_merge(
            $this->buildInheritanceTestDataEntry(ClassInterfaceType::class, InheritableType::class),
            $this->buildInheritanceTestDataEntry(ClassInterfaceType::class, NameableType::class),
            $this->buildInheritanceTestDataEntry(ClassType::class, ClassInterfaceType::class),
            $this->buildInheritanceTestDataEntry(InterfaceType::class, ClassInterfaceType::class),
        );
    }

    private function buildInheritanceTestDataEntry(string $type, string $expectedParentType): array {
        return [
            "{$type} is a {$expectedParentType}" => [$type, $expectedParentType],
        ];
    }
}