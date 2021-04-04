<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\ArrayType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\IntegerType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\Type;

/**
 * Tests the IntegerType class
 */
final class IntegerTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsTestData(): array
    {
        return [

            // Same type
            'is(int)' => ['int', true],
            'is(integer)' => ['integer', true],
            'is(IntegerType)' => [$this->createType(), true],
            'is(MockIntegerType)' => [
                $this->createMock(IntegerType::class),
                true
            ],

            // Different types
            'is(array)' => ['array', false],
            'is(ArrayType)' => [new ArrayType(), false],
            'is(bool)' => ['bool', false],
            'is(BooleanType)' => [new BooleanType(), false],
            'is(float)' => ['float', false],
            'is(FloatType)' => [new FloatType(), false],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        return [
            'isValueOfType(1)' => [1, true],
            'isValueOfType([])' => [[], false],
            'isValueOfType(1.0)' => [1.0, false],
            'isValueOfType(2.7)' => [2.7, false],
            'isValueOfType(false)' => [false, false],
        ];
    }


    protected function createType(): Type
    {
        return new IntegerType();
    }


    protected function getExpectedTypeName(): string
    {
        return 'integer';
    }
}
