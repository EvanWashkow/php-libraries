<?php
namespace PHP\Tests;

/**
 * Test data mapped by type
 *
 * Use this going forward for all future collection tests.
 */
final class CollectionsTestData
{
    
    /**
     * Retrieve a mapped array of sequence type => test data
     * 
     * @return array
     */
    public static function Get(): array
    {
        $typeMap = [
            'integer' => [
                0,
                1
            ],
            'string' => [
                '0',
                '1'
            ],
            'boolean' => [
                false,
                true
            ],
            'stdClass' => [
                new \stdClass(),
                (object) [ 0, 1 ]
            ],
            '' => [
                null
            ]
        ];
        foreach ( $typeMap as $type => $values ) {
            if ( '' !== $type ) {
                $typeMap[ '' ] = array_merge(
                    $typeMap[ '' ],
                    $values
                );
            }
        }
        return $typeMap;
    }
}
