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
        return [
            
            // Basic types
            [
                'in' => [
                    'value'     => true,
                    'name'      => 'boolean',
                    'shortName' => 'bool'
                ],
                'out' => [
                    'name'      => 'boolean',
                    'shortName' => 'bool'
                ]
            ],
            [
                'in' => [
                    'value'     => 1,
                    'name'      => 'integer',
                    'shortName' => 'int'
                ],
                'out' => [
                    'name'      => 'integer',
                    'shortName' => 'int'
                ]
            ],
            [
                'in' => [
                    'value'     => 'foobar',
                    'name'      => 'string'
                ],
                'out' => [
                    'name'      => 'string',
                    'shortName' => ''
                ]
            ],
            [
                'in' => [
                    'value'     => 1.5,
                    'name'      => 'double',
                    'shortName' => 'float'
                ],
                'out' => [
                    'name'      => 'double',
                    'shortName' => 'float'
                ]
            ],
            [
                'in' => [
                    'value'     => [],
                    'name'      => 'array'
                ],
                'out' => [
                    'name'      => 'array',
                    'shortName' => ''
                ]
            ],
            [
                'in' => [
                    'value'     => null,
                    'name'      => 'null'
                ],
                'out' => [
                    'name'      => 'null',
                    'shortName' => ''
                ]
            ],
            
            // Classes
            [
                'in' => [
                    'value'     => new \PHP\Collections\Sequence(),
                    'name'      => 'PHP\\Collections\\Sequence'
                ],
                'out' => [
                    'name'      => 'PHP\\Collections\\Sequence',
                    'shortName' => 'Sequence'
                ]
            ],
            
            // Functions
            [
                'in' => [
                    'name'      => 'function'
                ],
                'out' => [
                    'name'      => 'function',
                    'shortName' => ''
                ]
            ],
            [
                'in' => [
                    'name'      => 'substr'
                ],
                'out' => [
                    'name'      => 'function',
                    'shortName' => 'substr'
                ]
            ],
        ];
    }
}
