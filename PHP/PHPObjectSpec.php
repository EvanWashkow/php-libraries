<?php
namespace PHP;

/**
 * Specifications for an PHPObject
 */
interface PHPObjectSpec
{
    /**
     * Retrieve namespaced class string for this type
     *
     * @return string
     */
    public function getType(): string;
}
