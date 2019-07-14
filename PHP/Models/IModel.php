<?php
namespace PHP\Models;

trigger_error( 'IReadOnlyModel is deprecated', E_USER_DEPRECATED );

/**
 * Defines the basic structure for a Model
 */
interface IModel extends IReadOnlyModel
{
    
    /**
     * Set a property
     *
     * @param string $key   The property key
     * @param mixed  $value The new value for the property
     * @return bool If the property was successfully set or not
     */
    public function set( string $key, $value );
}
