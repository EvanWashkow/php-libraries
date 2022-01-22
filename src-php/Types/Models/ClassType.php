<?php

declare(strict_types=1);

namespace PHP\Types\Models;

/**
 * Retrieve type information for a class
 */
class ClassType extends InterfaceType
{
    /**
     * @internal Final: this class will always be a class.
     */
    final public function isClass(): bool
    {
        return true;
    }


    /**
     * @internal Final: this class can never be an interface.
     */
    final public function isInterface(): bool
    {
        return false;
    }
}
