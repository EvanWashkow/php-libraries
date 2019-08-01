<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\IntegerEnumTest;

use PHP\Collections\Dictionary;
use PHP\Enums\IntegerEnum;

class GoodIntegerEnum extends IntegerEnum
{

    const ONE = 1;

    const TWO = 2;

    const FOUR = 4;


    public function setValue( $value ): int
    {
        return parent::setValue( $value );
    }


    public function getConstants(): Dictionary
    {
        return parent::getConstants();
    }
}
