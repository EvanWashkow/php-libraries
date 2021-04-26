<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model\TestDefinition;

use PHP\Type\Model\Type;

/**
 * Defines a model to test Type->is(Type)
 */
final class TypeIsType extends TypeIs
{
    /** @var Type The Type to pass to is() */
    private $typeArg;

    /**
     * Creates a new TypeIsType instance
     *
     * @param Type $type Type->is(): the Type to call is() on
     * @param Type $typeArg is(Type): the Type to pass to is()
     * @param bool $expectedResult Expected return value of Type->is()
     */
    public function __construct(Type $type, Type $typeArg, bool $expectedResult)
    {
        parent::__construct($type, $expectedResult);
        $this->typeArg = $typeArg;
    }


    /**
     * Retrieve the Type to pass to is()
     */
    public function getTypeArg(): Type
    {
        return $this->typeArg;
    }
}
