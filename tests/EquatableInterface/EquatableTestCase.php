<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\EquatableInterface;

use EvanWashkow\PHPLibraries\EquatableInterface;

/**
 * A test case for EquatableInterface tests.
 */
final class EquatableTestCase
{
    private string $testName;

    private EquatableInterface $equatable;

    private $value;

    private bool $expected;

    /**
     * Creates a new EquatableInterfaceTestCase.
     *
     * @param string $testName The test name.
     * @param EquatableInterface $equatable The EquatableInterface to test.
     * @param mixed $value The value.
     * @param boolean $expected The expected test result.
     */
    public function __construct(string $testName, EquatableInterface $equatable, $value, bool $expected)
    {
        
        $this->testName = $testName;
        $this->equatable = $equatable;
        $this->value = $value;
        $this->expected = $expected;
    }

    /**
     * Get the test name.
     */ 
    public function getTestName(): string
    {
        return $this->testName;
    }

    /**
     * Get the EquatableInterface.
     */ 
    public function getEquatable(): EquatableInterface
    {
        return $this->equatable;
    }

    /**
     * Get the value to test.
     * 
     * @return mixed
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the expected test result.
     */ 
    public function getExpected(): bool
    {
        return $this->expected;
    }
}
