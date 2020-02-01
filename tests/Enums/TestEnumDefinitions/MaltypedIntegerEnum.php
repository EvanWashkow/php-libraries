<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\IntegerEnum;

class MaltypedIntegerEnum extends IntegerEnum
{

    const GOOD = 1;

    const BAD = '2';
}
