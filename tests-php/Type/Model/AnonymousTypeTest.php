<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\AnonymousType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\IntegerType;

/**
 * Tests the AnonymousType class
 */
final class AnonymousTypeTest extends TestDefinition\TypeTestDefinition
{
    public function getIsTestData(): array
    {
        $type = new AnonymousType();
        return [
            'AnonymousType' => [$type, $type, true],
            'BooleanType' => [$type, new BooleanType(), false],
            'FloatType' => [$type, new FloatType(), false],
            'IntegerType' => [$type, new IntegerType(), false],
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


    public function getNamesTestData(): array
    {
        return [
            '*' => [new AnonymousType(), '*'],
        ];
    }
}
