<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Type\TypeGetter;

use EvanWashkow\PhpLibraries\Type\Model\Type;
use PHP\Exceptions\NotFoundException;

/**
 * Describes a class that can retrieve type information
 */
interface ITypeGetter
{
    /**
     * Retrieves a Type by its name
     *
     * @param string $typeName The type name
     * @throws NotFoundException When the type does not exist. Is the type loaded?
     */
    public function getByName(string $typeName): Type;


    /**
     * Retrieves a Type by its value
     *
     * @param mixed $value The value
     */
    public function getByValue($value): Type;
}
