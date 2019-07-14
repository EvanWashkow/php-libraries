<?php
namespace PHP\Models;

trigger_error( 'IReadOnlyModel is deprecated', E_USER_DEPRECATED );

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
