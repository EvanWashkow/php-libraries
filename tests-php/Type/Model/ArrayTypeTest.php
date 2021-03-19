<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\ArrayType;
use PHP\Type\Model\Type;

/**
 * Tests the ArrayType class
 */
final class ArrayTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsTestData(): array
    {
        return [

            // Same type
            'is(array)'     => ['array',             true],
            'is(ArrayType)' => [$this->createType(), true],
            'is(MockArrayType)' => [
                $this->createMock(ArrayType::class),
                true
            ],

            /**
             * Different types
             *
             * @todo Add different Type instances to this test
             */
            'is(bool)'    => ['bool',    false],
            'is(float)'   => ['float',   false],
            'is(integer)' => ['integer', false],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        return [
            'isValueOfType([])'      => [[],      true],
            'isValueOfType([1,2,3])' => [[1,2,3], true],
            'isValueOfType(1)'       => [1,       false],
            'isValueOfType(2.7)'     => [2.7,     false],
            'isValueOfType(false)'   => [false,   false],
        ];
    }


    protected function createType(): Type
    {
        return new ArrayType();
    }


    protected function getExpectedTypeName(): string
    {
        return 'array';
    }
}