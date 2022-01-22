<?php

declare(strict_types=1);

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\StringEnum;

class MaltypedStringEnum extends StringEnum
{
    public const GOOD = '1';

    public const BAD = 2;
}
