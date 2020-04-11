<?php
namespace PHP\Debug;

// Deprecated (04-2020)
trigger_error(
    Log::class . ' is deprecated.',
    E_USER_DEPRECATED
);

/**
 * Defines a helper for logging debug messages to the system
 */
class Log
{
    
    /**
     * Writes a message to the system log
     *
     * @param mixed $message The message to output
     */
    public static function Write( $message )
    {
        if ( is_array( $message ) || is_object( $message )) {
            $message = print_r( $message, true );
        }
        elseif ( is_bool( $message )) {
            $message = $message ? 'true' : 'false';
        }
        error_log( $message );
    }
}
