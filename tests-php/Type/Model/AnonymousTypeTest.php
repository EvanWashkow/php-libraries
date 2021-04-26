<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\AnonymousType;

/**
 * Tests the AnonymousType class
 */
final class AnonymousTypeTest extends TestDefinition\TypeTestDefinition
{
    public function getNamesTestData(): array
    {
        return [
            '*' => [new AnonymousType(), '*'],
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
}
