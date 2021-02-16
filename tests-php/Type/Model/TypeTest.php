<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\ObjectClass;
use PHP\Type\Model\Type;

/**
 * Tests the Type class
 */
final class TypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Checks the type of Type
     */
    public function testType(): void
    {
        $this->assertInstanceOf(
            ObjectClass::class,
            $this->getType()
        );
    }


    /**
     * Retrieve type instance for this test
     */
    private function getType(): Type
    {
        static $type = null;
        if ($type === null)
        {
            $type = $this->createMock(Type::class);
        }
        return $type;
    }
}
