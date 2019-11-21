<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Enums\Exceptions\MalformedEnumException;

/**
 * Retrieves information about a string enumeration
 */
class StringEnumInfo extends EnumInfo
{


    /**
     * @see parent::maybeThrowMalformedEnumException()
     */
    protected function maybeThrowMalformedEnumException(): void
    {
        foreach ( $this->getConstants()->toArray() as $constantName => $constantValue ) {
            if ( !is_string( $constantValue ) ) {
                throw new MalformedEnumException(
                    "All StringEnum constants must be strings. \"{$this->getClassType()->getName()}::{$constantName}\" is not a string."
                );
            }
        }
    }
}
