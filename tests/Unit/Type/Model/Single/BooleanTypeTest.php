<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\Single;

use EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\TestDefinition\TypeTestDefinition;
use EvanWashkow\PhpLibraries\Type\Model\Single\ArrayType;
use EvanWashkow\PhpLibraries\Type\Model\Single\BooleanType;
use EvanWashkow\PhpLibraries\Type\Model\Single\FloatType;
use EvanWashkow\PhpLibraries\Type\Model\Single\IntegerType;

/**
 * Tests the BooleanType class
 */
final class BooleanTypeTest extends TypeTestDefinition
{

    /**
     * @inheritDoc
     */
    public function getIsTestData(): array
    {
        $type = new BooleanType();
        $childType = new class extends BooleanType{};
        return [
            'BooleanType' => [$type, $type, true],
            'BooleanType->is(ChildType)' => [$type, $childType, true],
            'ChildType->is(BooleanType)' => [$childType, $type, true],
            'ArrayType' => [$type, new ArrayType(), false],
            'FloatType' => [$type, new FloatType(), false],
            'IntegerType' => [$type, new IntegerType(), false],
            'bool' => [$type, 'bool', true],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIsUnknownTypeNameTestData(): array
    {
        return [
            'BooleanType' => [new BooleanType()]
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIsValueOfTypeTestData(): array
    {
        $type = new BooleanType();
        return [
            'true' => [$type, true, true],
            'false' => [$type, false, true],
            '[]' => [$type, [], false],
            '1' => [$type, 1, false],
            '2.7' => [$type, 2.7, false],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getNameTestData(): array
    {
        return [
            'BooleanType' => [new BooleanType(), BooleanType::BOOLEAN_NAME]
        ];
    }
}
