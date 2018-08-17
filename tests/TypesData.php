<?php
namespace PHP\Tests;

/**
 * Defines data for PHP\Types tests
 */
final class TypesData
{
    
    /**
     * Retrieve an array of test data to run against types
     *
     * All "in" keys are valid type queries. If a key is not specified, a test
     * will not be run on it.
     *
     * All "out" keys are the expected results of the "in" type query. If a key
     * is not specified, it will not be tested.
     *
     * @return array
     */
    public static function Get(): array
    {
        // Define base parameters for out
        $outBase = [
            'aliases' => []
        ];
        
        return [
            
            // Known types
            [
                'in' => [
                    'value' => true,
                    'names' => [ 'bool', 'boolean' ],
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name'    => 'bool',
                        'aliases' => [ 'boolean' ]
                    ]
                )
            ],
            [
                'in' => [
                    'value' => 1,
                    'names' => [ 'int', 'integer' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name'    => 'int',
                        'aliases' => [ 'integer' ]
                    ]
                )
            ],
            [
                'in' => [
                    'value' => '1',
                    'names' => [ 'string' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name' => 'string'
                    ]
                )
            ],
            [
                'in' => [
                    'value' => 1.0,
                    'names' => [ 'double', 'float' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name'    => 'float',
                        'aliases' => [ 'double' ]
                    ]
                )
            ],
            [
                'in' => [
                    'value' => [],
                    'names' => [ 'array' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name' => 'array'
                    ]
                )
            ],
            
            // Nullity
            [
                'in' => [
                    'value' => null,
                    'names' => [ 'null' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name' => 'null'
                    ]
                )
            ],
            [
                'in' => [
                    'value' => NULL,
                    'names' => [ 'NULL' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name' => 'null'
                    ]
                )
            ],
            
            // Classes
            [
                'in' => [
                    'value' => new \PHP\Collections\Sequence(),
                    'names' => [ 'PHP\\Collections\\Sequence' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name' => 'PHP\\Collections\\Sequence'
                    ]
                )
            ],
            
            // Functions
            [
                'in' => [
                    'names' => [ 'function' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name' => 'function'
                    ]
                )
            ],
            [
                'in' => [
                    'names' => [ 'substr' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name' => 'function'
                    ]
                )
            ],
            
            // Unknown type
            [
                'in' => [
                    'names' => [ 'foobar' ]
                ],
                'out' => array_merge(
                    $outBase,
                    [
                        'name' => 'unknown type'
                    ]
                )
            ]
        ];
    }
}
