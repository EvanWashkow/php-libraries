<?php

declare(strict_types=1);

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
     *
     * @return array
     */
    public static function create(string $testPrefix, string $className, \Closure $new): array
    {
        return [
            // Want integer value
            "{$testPrefix} {$className} invalid value type - want integer, got array" => [ $new(new IntegerType()), [] ],
            "{$testPrefix} {$className} invalid value type - want integer, got boolean" => [ $new(new IntegerType()), true ],
            "{$testPrefix} {$className} invalid value type - want integer, got object" => [ $new(new IntegerType()), new class() {
            },
            ],
            "{$testPrefix} {$className} invalid value type - want integer, got float" => [ $new(new IntegerType()), 1.2 ],
            "{$testPrefix} {$className} invalid value type - want integer, got string" => [ $new(new IntegerType()), 'string' ],

            // Want string value
            "{$testPrefix} {$className} invalid value type - want string, got array" => [ $new(new StringType()), [] ],
            "{$testPrefix} {$className} invalid value type - want string, got boolean" => [ $new(new StringType()), true ],
            "{$testPrefix} {$className} invalid value type - want string, got object" => [ $new(new StringType()), new class() {
            },
            ],
            "{$testPrefix} {$className} invalid value type - want string, got float" => [ $new(new StringType()), 1.2 ],
            "{$testPrefix} {$className} invalid value type - want string, got integer" => [ $new(new StringType()), 1 ],
        ];
    }

    /**
     * Create invalid value type tests with a key
     *
     * @param string $testPrefix The test name prefix
     * @param string $className The collection class
     * @param \Closure $new Creates a new collection for the value type
     * @param mixed $key A valid key for the collection
     *
     * @return array
     */
    public static function createWithKey(string $testPrefix, string $className, \Closure $new, mixed $key): array
    {
        $array = [];
        foreach (self::create($testPrefix, $className, $new) as $description => $params) {
            $array[$description] = [$params[0], $key, $params[1]];
        }
        return $array;
    }
}
