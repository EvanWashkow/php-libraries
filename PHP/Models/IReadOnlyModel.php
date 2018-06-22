<?php
namespace PHP\Models;

/**
 * Defines the basic structure for a read-only Model
 */
interface IReadOnlyModel extends \PHP\IPHPObject
{
    
    /**
     * Retrieve a property
     *
     * @param string $key The property key
     * @return mixed The property value
     */
    public function get( string $key );
}
