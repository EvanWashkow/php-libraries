<?php
namespace PHP;

/**
 * Specifications for an Object
 */
interface ObjectSpec
{
    /**
     * Retrieve namespaced class string for this type
     *
     * @return string
     */
    public function getType(): string;
}
