<?php

declare(strict_types=1);

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\Enum;

class GoodEnum extends Enum
{
    public const ONE_FLOAT = 1.0;

    public const ONE_INTEGER = 1;

    public const ONE_STRING = '1';

    public const ARRAY = [ 1, 2, 3 ];


    /**
     * Converts this integer array to a string array
     */
    final public static function GetStringArray(): array
    {
        $stringArray = [];
        foreach (GoodEnum::ARRAY as $value) {
            $stringArray[] = "$value";
        }
        return $stringArray;
    }
}
