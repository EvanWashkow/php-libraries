<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Type\Model;

use EvanWashkow\PhpLibraries\Type\Model\ArrayType;
use EvanWashkow\PhpLibraries\Type\Model\BooleanType;
use EvanWashkow\PhpLibraries\Type\Model\FloatType;
use EvanWashkow\PhpLibraries\Type\Model\StringType;

final class StringTypeTest extends TestDefinition\TypeTestDefinition
{

    /**
     * @inheritDoc
     */
    public function getIsTestData(): array
    {
        $type = new StringType();
        $childType = new class extends StringType {};
        return [
            'StringType' => [$type, $type, true],
            'StringType->is(ChildType)' => [$type, $childType, true],
            'ChildType->is(StringType)' => [$childType, $type, true],
            'ArrayType' => [$type, new ArrayType(), false],
            'BooleanType' => [$type, new BooleanType(), false],
            'FloatType' => [$type, new FloatType(), false],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIsUnknownTypeNameTestData(): array
    {
        return [
            'StringType' => [new StringType()],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIsValueOfTypeTestData(): array
    {
        $type = new StringType();
        return [
            'foobar' => [$type, 'foobar', true],
            'lorem' => [$type, 'lorem', true],
            'ipsum' => [$type, 'ipsum', true],
            '1' => [$type, 1, false],
            '[]' => [$type, [], false],
            '1.0' => [$type, 1.0, false],
            '2.7' => [$type, 2.7, false],
            'false' => [$type, false, false],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getNameTestData(): array
    {
        return [
            'StringType' => [new StringType(), StringType::NAME],
        ];
    }
}
