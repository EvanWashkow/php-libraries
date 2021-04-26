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
}
