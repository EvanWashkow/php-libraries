<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type\Model;

use EvanWashkow\PHPLibraries\Type\Model\AnonymousType;
use EvanWashkow\PHPLibraries\Type\Model\BooleanType;
use EvanWashkow\PHPLibraries\Type\Model\FloatType;
use EvanWashkow\PHPLibraries\Type\Model\IntegerType;

/**
 * Tests the AnonymousType class
 */
final class AnonymousTypeTest extends TestDefinition\TypeTestDefinition
{
    public function getIsTestData(): array
    {
        $type = new AnonymousType();
        $childType = new class extends AnonymousType{};
        return [
            'AnonymousType' => [$type, $type, true],
            'AnonymousType->is(ChildType)' => [$type, $childType, true],
            'ChildType->is(AnonymousType)' => [$childType, $type, true],
            'BooleanType' => [$type, new BooleanType(), false],
            'FloatType' => [$type, new FloatType(), false],
            'IntegerType' => [$type, new IntegerType(), false],
        ];
    }

    public function getIsUnknownTypeNameTestData(): array
    {
        return [
            'AnonymousType' => [new AnonymousType()]
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        $type = new AnonymousType();
        return [
            '[]'    => [$type, [],    false],
            '1'     => [$type, 1,     false],
            '2.7'   => [$type, 2.7,   false],
            'false' => [$type, false, false],
        ];
    }


    public function getNameTestData(): array
    {
        return [
            'AnonymousType' => [new AnonymousType(), '*'],
        ];
    }
}
