<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type\Model;

use EvanWashkow\PHPLibraries\Type\Model\ArrayType;
use EvanWashkow\PHPLibraries\Type\Model\BooleanType;
use EvanWashkow\PHPLibraries\Type\Model\FloatType;
use EvanWashkow\PHPLibraries\Type\Model\IntegerType;

/**
 * Tests the FloatType class
 */
final class FloatTypeTest extends TestDefinition\TypeTestDefinition
{

    /**
     * @inheritDoc
     */
    public function getIsTestData(): array
    {
        $type = new FloatType();
        $childType = new class extends FloatType {};
        return [
            'FloatType' => [$type, $type, true],
            'FloatType->is(ChildType)' => [$type, $childType, true],
            'ChildType->is(FloatType)' => [$childType, $type, true],
            'ArrayType' => [$type, new ArrayType(), false],
            'BooleanType' => [$type, new BooleanType(), false],
            'IntegerType' => [$type, new IntegerType(), false],
            'double' => [$type, 'double', true],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIsUnknownTypeNameTestData(): array
    {
        return [
            'FloatType' => [new FloatType()],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIsValueOfTypeTestData(): array
    {
        $type = new FloatType();
        return [
            '-8.9' => [$type, -8.9, true],
            '1.0' => [$type, 1.0, true],
            '31.4' => [$type, 31.4, true],
            '[]' => [$type, [], false],
            'false' => [$type, false, false],
            '1' => [$type, 1, false],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getNameTestData(): array
    {
        return [
            'FloatType' => [new FloatType(), 'float'],
        ];
    }
}
