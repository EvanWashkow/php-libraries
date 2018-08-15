<?php
namespace PHP\Tests;

/**
 * Test custom PHP functions
 */
class FunctionsTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                                   is()
    ***************************************************************************/
    
    /**
     * Test all is() type comparisons
     */
    public function testIs()
    {
        $typeStringInstancesMap = [
            'array' => [
                [],
                array(),
                [ 1, 2, 3 ],
                array( 1, 2, 3 )
            ],
            'boolean' => [
                true,
                false
            ],
            'double'=> [
                0.5,
                1.5
            ],
            'integer' => [
                -100,
                -1,
                0,
                1,
                100
            ],
            'string' => [
                'true',
                'false',
                '0.5',
                '1.5',
                '0',
                '1',
                'foobar',
            ],
            'NULL' => [
                NULL
            ],
            'PHP\Collections\Collection' => [
                new \PHP\Collections\Dictionary(),
                new \PHP\Collections\Sequence(),
                new \PHP\Cache()
            ],
            'PHP\URL' => [
                new \PHP\URL( 'https://google.com' )
            ]
        ];
        
        // For each type string, ensure is() returns true for its instances and
        // false for every other type's instances
        foreach ( $typeStringInstancesMap as $typeString => $typeInstances ) {
            
            // Ensure is() returns true for that type's instances
            foreach ( $typeInstances as $i => $typeInstance ) {
                $this->assertTrue(
                    is( $typeInstance, $typeString ),
                    "is() failed to identify instance at index {$i} as a {$typeString}"
                );
            }
            
            // Ensure is() returns false for every other type instances
            foreach ( $typeStringInstancesMap as $otherTypeString => $otherTypeInstances ) {
                if ( $otherTypeString !== $typeString ) {
                    foreach ( $otherTypeInstances as $i => $otherTypeInstance ) {
                        $this->assertFalse(
                            is( $otherTypeInstance, $typeString ),
                            "is() incorrectly identified a {$otherTypeString} instance at index{$i} as a {$typeString}"
                        );
                    }
                }
            }
        }
    }
}
