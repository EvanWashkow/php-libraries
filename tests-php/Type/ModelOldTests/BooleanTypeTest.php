<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\ModelOldTests;

use PHP\Type\Model\ArrayType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\IntegerType;
use PHP\Type\Model\Type;

/**
 * Tests the BooleanType class
 */
final class BooleanTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsOfTypeTestData(): array
    {
        return [
            'is(BooleanType)' => [$this->getOrCreateType(), true],
            'is(ArrayType)' => [new ArrayType(), false],
            'is(FloatType)' => [new FloatType(), false],
            'is(IntegerType)' => [new IntegerType(), false],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        return [
            'isValueOfType(true)' => [true, true],
            'isValueOfType(false)' => [false, true],
            'isValueOfType([])' => [[], false],
            'isValueOfType(1)' => [1, false],
            'isValueOfType(2.7)' => [2.7, false],
        ];
    }


    protected function createType(): Type
    {
        return new BooleanType();
    }


    protected function getExpectedTypeName(): string
    {
        return 'boolean';
    }


    protected function getIsOfTypeNameCustomTestData(): array
    {
        return [
            'is(boolean)' => ['boolean', true],
        ];
    }
}
