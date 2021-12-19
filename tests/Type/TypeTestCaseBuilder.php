<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\Type;

/**
 * Builds a TypeTestCase
 */
final class TypeTestCaseBuilder
{
    private Type $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    /**
     * Build a TypeTestCase
     * 
     * @throws \UnexpectedValueException on bad TypeTestCase data
     */
    public function build(): TypeTestCase
    {
        return new TypeTestCase(clone $this);
    }
}