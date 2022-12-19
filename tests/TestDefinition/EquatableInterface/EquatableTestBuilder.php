<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\TestDefinition\EquatableInterface;

use EvanWashkow\PHPLibraries\Equatable;

/**
 * Builds test data for AbstractEquatableInterfaceTestCase.
 *
 * - A test for self equivalence will be added on Builder creation.
 * - A test for bidirectional equality will be added when calling equals().
 */
final class EquatableTestBuilder
{
    private string $testHeader;
    private Equatable $equatable;
    private array $equals;
    private array $notEquals;

    /**
     * Creates a new EquatableTestDataBuilder.
     *
     * @param string             $testHeader the testHeader description for all tests
     * @param Equatable $equatable  the EquatableInterface instance
     */
    public function __construct(string $testHeader, Equatable $equatable)
    {
        $this->testHeader = $testHeader;
        $this->equatable = $equatable;
        $this->equals = [];
        $this->notEquals = [];

        // The object must be equivalent to itself.
        $this->equals('self', $equatable);
    }

    /**
     * Add test for value that should be equal.
     *
     * @param string $testEntry the test entry description
     * @param mixed  $value     the value to test
     */
    public function equals(string $testEntry, mixed $value): self
    {
        $this->equals["{$this->testHeader} equals {$testEntry}"] =
            $this->newTestData($this->equatable, $value, true);

        if ($value instanceof Equatable) {
            $this->equals["{$this->testHeader} bidirectionally equals {$testEntry}"] =
                $this->newTestData($value, $this->equatable, true);
        }

        return $this;
    }

    /**
     * Add test for value that should not be equal.
     *
     * @param string $testEntry the test entry description
     * @param mixed  $value     the value to test
     */
    public function notEquals(string $testEntry, mixed $value): self
    {
        $this->notEquals["{$this->testHeader} should not equal {$testEntry}"] =
            $this->newTestData($this->equatable, $value, false);

        return $this;
    }

    /**
     * Builds a set of EquatableTestCases.
     */
    public function build(): array
    {
        if (count($this->notEquals) <= 0) {
            throw new \DomainException('insufficient test cases for EquatableInterface');
        }

        return array_merge($this->equals, $this->notEquals);
    }

    /**
     * Creates a new test case.
     *
     * @param Equatable $equatable the equatable object under test
     * @param mixed              $value     the value to test
     * @param bool               $expected  the expected result
     */
    private function newTestData(Equatable $equatable, mixed $value, bool $expected): array
    {
        return [$equatable, $value, $expected];
    }
}
