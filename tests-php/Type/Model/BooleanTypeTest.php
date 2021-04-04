<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model;

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
    public function getIsTestData(): array
    {
        return [

            // Same type
            'is(bool)' => ['bool', true],
            'is(boolean)' => ['boolean', true],
            'is(BooleanType)' => [$this->createType(), true],
            'is(MockBooleanType)' => [
                $this->createMock(BooleanType::class),
                true
            ],

            // Different types
            'is(array)' => ['array', false],
            'is(ArrayType)' => [new ArrayType(), false],
            'is(float)' => ['float', false],
            'is(FloatType)' => [new FloatType(), false],
            'is(integer)' => ['integer', false],
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
}
