<?php

declare(strict_types=1);

namespace PHP\Collections\Dictionary;

use PHP\Collections\Collection\AnonymousKeyType;
use PHP\Types\Models\Type;

/**
 * Anonymous type for dictionary keys that returns true for ints and strings.
 */
class DictionaryAnonymousKeyType extends AnonymousKeyType
{
    public function is(string $typeName): bool
    {
        return in_array($typeName, ['int', 'string'], true);
    }

    public function isClass(): bool
    {
        return false;
    }

    public function isInterface(): bool
    {
        return false;
    }

    public function isValueOfType($value): bool
    {
        return is_int($value) || is_string($value);
    }
}
