<?php

namespace EvanWashkow\PhpLibraries\Tests\Collection;
use EvanWashkow\PhpLibraries\Type\IntegerType;
use EvanWashkow\PhpLibraries\Type\StringType;

/**
 * Defines invalid value types for collection tests
 */
final class InvalidValueTypes
{
    /**
     * Create invalid value type tests
     * 
     * @param string $testPrefix The test name prefix
     * @param string $className The collection class
     * @param \Closure $new Creates a new collection for the value type
     * @param mixed $key A valid key for the collection
     * @return array
     */
    public static function createWithKey(string $testPrefix, string $className, \Closure $new, mixed $key): array {
        return [
            // Want integer value
            "{$testPrefix} {$className} invalid value type - want integer, got array" => [ $new(new IntegerType()), $key, [] ],
            "{$testPrefix} {$className} invalid value type - want integer, got boolean" => [ $new(new IntegerType()), $key, true ],
            "{$testPrefix} {$className} invalid value type - want integer, got object" => [ $new(new IntegerType()), $key, new class() {
            },
            ],
            "{$testPrefix} {$className} invalid value type - want integer, got float" => [ $new(new IntegerType()), $key, 1.2 ],
            "{$testPrefix} {$className} invalid value type - want integer, got string" => [ $new(new IntegerType()), $key, 'string' ],

            // Want string value
            "{$testPrefix} {$className} invalid value type - want string, got array" => [ $new(new StringType()), $key, [] ],
            "{$testPrefix} {$className} invalid value type - want string, got boolean" => [ $new(new StringType()), $key, true ],
            "{$testPrefix} {$className} invalid value type - want string, got object" => [ $new(new StringType()), $key, new class() {
            },
            ],
            "{$testPrefix} {$className} invalid value type - want string, got float" => [ $new(new StringType()), $key, 1.2 ],
            "{$testPrefix} {$className} invalid value type - want string, got integer" => [ $new(new StringType()), $key, 1 ],
        ];
    }
}
