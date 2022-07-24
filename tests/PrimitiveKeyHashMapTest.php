<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests;

use EvanWashkow\PHPLibraries\Collection\PrimitiveKeyHashMap;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

final class PrimitiveKeyHashMapTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getGetKeyTypeTestData
     */
    public function testGetKeyType(PrimitiveKeyHashMap $map, Type $expectedType): void {
        $mapType = new ClassType(get_class($map->getKeyType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Map->getKeyType() returned the wrong type');
    }

    public function getGetKeyTypeTestData(): array {
        return [
            IntegerType::class => [new PrimitiveKeyHashMap(new IntegerType(), new ArrayType()), new IntegerType()],
            StringType::class => [new PrimitiveKeyHashMap(new StringType(), new BooleanType()), new StringType()],
        ];
    }

    /**
     * @dataProvider getGetValueTypeTestData
     */
    public function testGetValueType(PrimitiveKeyHashMap $map, Type $expectedType): void {
        $mapType = new ClassType(get_class($map->getValueType()));
        $expectedTypeType = new ClassType(get_class($expectedType));
        $this->assertTrue($mapType->equals($expectedTypeType), 'Map->getValueType() returned the wrong type');
    }

    public function getGetValueTypeTestData(): array {
        return [
            ArrayType::class => [new PrimitiveKeyHashMap(new IntegerType(), new ArrayType()), new ArrayType()],
            BooleanType::class => [new PrimitiveKeyHashMap(new StringType(), new BooleanType()), new BooleanType()],
        ];
    }
}
