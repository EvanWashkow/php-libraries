<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\StringEnumTest;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\Enums\StringEnum;

class GoodStringEnum extends StringEnum
{

    const ONE = '1';

    const TWO = '2';

    const FOUR = '4';


    public function setValue( $value ): Enum
    {
        return parent::setValue( $value );
    }


    public function getConstants(): Dictionary
    {
        return parent::getConstants();
    }
}
