<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\Type;
use PHPUnit\Framework\TestCase;

/**
 * Tests Types
 */
final class TypeTest extends TestCase
{
    /**
     * @dataProvider getFinalData
     */
    public function testFinal(Type $type)
    {
        $rc = new \ReflectionClass($type);
        $this->assertTrue($rc->isFinal(), "Type is not final");
    }

    public function getFinalData(): array
    {
        return [
            ArrayType::class => [new ArrayType()],
        ];
    }
}