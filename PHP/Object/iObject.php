<?php
namespace PHP\Object;

/**
 * Defines the Object type
 */
interface iObject
{
    /**
     * Retrieve namespaced class string for this type
     *
     * @return string
     */
    public function GetType(): string;
}
