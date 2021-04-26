<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model\TestDefinition;

use PHP\Type\Model\Type;

/**
 * Defines a base model for Type->is() tests
 */
abstract class TypeIsTestModel
{
    /** @var bool The expected result of calling is() */
    private $expectedResult;

    /** @var Type The Type to call is() on */
    private $type;


    /**
     * Creates a new TypeIsTestModel instance
     *
     * @param Type $type The Type to call is() on
     * @param bool $expectedResult The expected result of calling is()
     */
    public function __construct(Type $type, bool $expectedResult)
    {
        $this->type           = $type;
        $this->expectedResult = $expectedResult;
    }


    /**
     * Retrieve the expected result of calling is()
     */
    final public function getExpectedResult(): bool
    {
        return $this->expectedResult;
    }


    /**
     * Retrieve the Type instance to call is() on.
     */
    final public function getType(): Type
    {
        return $this->type;
    }
}
