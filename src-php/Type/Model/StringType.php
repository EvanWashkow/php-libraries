<?php
declare(strict_types=1);

namespace PHP\Type\Model;

/**
 * Defines a string type
 */
class StringType extends Type
{
    public function __construct()
    {
        parent::__construct('string');
    }

    public function isValueOfType($value): bool
    {

    }

    protected function isOfType(Type $type): bool
    {

    }

    protected function isOfTypeName(string $typeName): bool
    {

    }
}
