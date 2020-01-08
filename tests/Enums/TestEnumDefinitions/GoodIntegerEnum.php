<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;

class GoodIntegerEnum extends IntegerEnum
{

    const ONE = 1;

    const TWO = 2;

    const FOUR = 4;

    private const PRIVATE_CONSTANT = 1;
}
