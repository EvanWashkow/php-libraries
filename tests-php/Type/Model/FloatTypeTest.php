<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\ArrayType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\IntegerType;
use PHP\Type\Model\Type;

/**
 * Tests the FloatType class
 */
final class FloatTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsOfTypeTestData(): array
    {
        return [
            'is(FloatType)' => [$this->createType(), true],
            'is(ArrayType)' => [new ArrayType(), false],
            'is(BooleanType)' => [new BooleanType(), false],
            'is(IntegerType)' => [new IntegerType(), false],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        return [
            'isValueOfType(-8.9)' => [-8.9, true],
            'isValueOfType(1.0)' => [1.0, true],
            'isValueOfType(31.4)' => [31.4, true],
            'isValueOfType([])' => [[], false],
            'isValueOfType(false)' => [false, false],
            'isValueOfType(1)' => [1, false],
        ];
    }


    protected function createType(): Type
    {
        return new FloatType();
    }


    protected function getExpectedTypeName(): string
    {
        return 'float';
    }

    protected function getIsOfTypeNameCustomTestData(): array
    {
        return [
            'is(double)' => ['double', true],
        ];
    }
}
