<?php

declare(strict_types=1);

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\Enum;

class PrivateConstantEnum extends Enum
{
    public const PUBLIC = 'public';

    private const PRIVATE = 'private';
}
