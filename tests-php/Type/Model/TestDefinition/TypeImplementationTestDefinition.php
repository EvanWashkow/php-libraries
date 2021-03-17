<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model\TestDefinition;

use PHP\Type\Model\Type;
use PHPUnit\Framework\TestCase;

/**
 * Defines a test for Type implementations
 */
abstract class TypeImplementationTestDefinition extends TestCase
{
    /** @var ?Type The Type instance */
    private $type = null;


    /**
     * Creates a new Type instance to be tested
     */
    abstract protected function createType(): Type;


    /**
     * Creates or returns a singleton instance of the Type to be tested
     */
    final protected function getOrCreateType(): Type
    {
        if (! $this->type instanceof Type)
        {
            $this->type = $this->createType();
        }
        return $this->type;
    }
}