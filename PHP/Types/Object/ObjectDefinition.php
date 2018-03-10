<?php
namespace PHP\Types\Object;

/**
 * Defines the Object type
 */
interface ObjectDefinition
{
    /**
     * Retrieve namespaced class string for this type
     *
     * @return string
     */
    public function GetType(): string;
}
