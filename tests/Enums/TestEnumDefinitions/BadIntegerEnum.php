<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\IntegerEnum;

class BadIntegerEnum extends IntegerEnum
{

    const ONE = 1;

    const TWO = '2';
}
