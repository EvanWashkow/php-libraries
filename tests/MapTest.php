<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests;

use EvanWashkow\PHPLibraries\Collection\Map;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

final class MapTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getGetKeyTypeTestData
     */
    public function testGetKeyType(Map $map, Type $expectedType): void {
        $mapType = new ClassType(get_class($map->getKeyType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Map->getKeyType() returned the wrong type');
    }

    public function getGetKeyTypeTestData(): array {
        return [
            IntegerType::class => [new Map(new IntegerType(), new ArrayType()), new IntegerType()],
            StringType::class => [new Map(new StringType(), new ArrayType()), new StringType()],
        ];
    }
}
