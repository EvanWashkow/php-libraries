<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;

class GoodEnum extends Enum
{

    const STRING = '123';

    const NUMBERS = 234;

    const ARRAY = [ 1, 2, 3 ];

    private const PRIVATE_CONSTANT = 1;


    /**
     * Converts this integer array to a string array
     */
    final public static function GetStringArray(): array
    {
        $stringArray = [];
        foreach ( GoodEnum::ARRAY as $value ) {
            $stringArray[] = "$value";
        }
        return $stringArray;
    }
}
