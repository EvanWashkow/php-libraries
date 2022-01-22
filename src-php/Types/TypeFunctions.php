<?php

declare(strict_types=1);

use PHP\Types\TypeNames;

/**
 * Determine if the value is, or is derived from, the type
 *
 * @param mixed  $value The value
 * @param string $type  Type name to compare the value to
 * @return bool
 */
function is($value, string $type): bool
{
    $result;
    switch ($type) {
        case TypeNames::ARRAY:
            $result = is_array($value);
            break;

        case TypeNames::BOOL:
        case TypeNames::BOOLEAN:
            $result = is_bool($value);
            break;

        case TypeNames::DOUBLE:
        case TypeNames::FLOAT:
            $result = is_float($value);
            break;

        case TypeNames::INT:
        case TypeNames::INTEGER:
            $result = is_int($value);
            break;

        case TypeNames::NULL:
            $result = (null === $value);
            break;

        case TypeNames::STRING:
            $result = is_string($value);
            break;

        default:
            if (class_exists($type) || interface_exists($type)) {
                $result = is_a($value, $type);
            } else {
                $result = false;
            }
            break;
    }
    return $result;
}
