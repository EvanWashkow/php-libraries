<?php

declare(strict_types=1);

namespace PHP\Interfaces;

/**
 * Describes an object that can be duplicated
 *
 * @internal PHP makes the assumption that all objects can be cloned (via `clone $x`). This is an incorrect assumption
 * to make since not every implementation wants to allow it. This interface provides an object-oriented way to implement
 * and indicate clonability on a class-by-class basis. Additionally, this method is called before cloning happens,
 * whereas the magic "__clone" method is called after, which gives far more control.
 */
interface ICloneable
{
    /**
     * Make a copy of this object
     *
     * @return ICloneable
     */
    public function clone(): ICloneable;
}
