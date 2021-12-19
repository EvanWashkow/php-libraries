<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\Type;

final class TypeTestCase
{
    private TypeTestCaseBuilder $builder;

    public function __construct(TypeTestCaseBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getType(): Type
    {
        return $this->builder->getType();
    }
}
