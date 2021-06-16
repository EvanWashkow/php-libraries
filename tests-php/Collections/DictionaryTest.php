<?php
declare(strict_types=1);

namespace PHP\Tests\Collections;

use PHP\Byte;
use PHP\Collections\ByteArray;
use PHP\Collections\Dictionary;

/**
 * Tests the Dictionary class
 */
final class DictionaryTest extends CollectionTestDefinition
{

    public function getSerializationTestData(): array
    {
        return [
            'Dictionary(int, int)' => [
                new Dictionary('int', 'int', [1, 2, 3]),
            ],
            'Dictionary(string, int)' => [
                new Dictionary(
                    'string',
                    'int',
                    [
                        'one' => 1,
                        'two' => 2,
                        'three' => 3
                    ]
                ),
            ],
            'Dictionary(int, float)' => [
                new Dictionary('int', 'float', [8.9, 3.10, 2.7]),
            ],
            'Dictionary(int, Byte)' => [
                new Dictionary(
                    'int',
                    Byte::class,
                    [
                        new Byte(1),
                        new Byte(2),
                        new Byte(3)
                    ]
                ),
            ],
            'Dictionary(string, ByteArray)' => [
                new Dictionary(
                    'string',
                    ByteArray::class,
                    [
                        'one' => new ByteArray( 1 ),
                        'two' => new ByteArray( 2 ),
                        'three' => new ByteArray( 3 )
                    ]
                ),
            ],
        ];
    }
}
