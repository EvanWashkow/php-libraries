<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model\TestDefinition;

use PHP\Type\Model\Type;

/**
 * Defines a model to test Type->is(string $typeName)
 *
 * Used to test test Type->is(string $typeName)
 */
final class TypeIsTypeName extends TypeIs
{
    /** @var string The type name string to pass to is() */
    private $typeName;


    /**
     * TypeIsTypeName constructor.
     *
     * @param Type $type Type->is(): the Type to call is() on
     * @param string $typeName is(string $typeName): the type name string to pass to is()
     * @param bool $expectedResult Expected return value of Type->is()
     */
    public function __construct(Type $type, string $typeName, bool $expectedResult)
    {
        parent::__construct($type, $expectedResult);
        $this->typeName = $typeName;
    }


    /**
     * Retrieve the type name string to pass to is()
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }
}
