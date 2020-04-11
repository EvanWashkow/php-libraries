<?php
namespace PHP\Debug;

// Deprecated (04-2020)
trigger_error(
    StackTrace::class . ' is deprecated.',
    E_USER_DEPRECATED
);

/**
 * @deprecated
 */
final class StackTrace
{
    
    /**
     * Retrieves the current system stack trace
     *
     * @return array
     */
    public static function Get(): array
    {
        return debug_backtrace();
    }
    
    
    /**
     * Convert this stack trace into a human-readable string
     *
     * @return string
     */
    public static function ToString(): string
    {
        // Variables
        $output     = "\n";
        $stackTrace = self::get();
        
        // Pop StackTrace entries off
        array_shift( $stackTrace );
        array_shift( $stackTrace );
        
        // For each stack trace entry, convert it to a string
        foreach ( $stackTrace as $entry ) {
            
            // Variables
            $caller = $entry[ 'function' ];
            $file   = '';
            $line   = '';
            if ( array_key_exists( 'class', $entry )) {
                $caller = $entry[ 'class' ] . $entry[ 'type' ] . $caller;
            }
            if ( array_key_exists( 'file', $entry )) {
                $file = $entry[ 'file' ];
            }
            if ( array_key_exists( 'line', $entry )) {
                $line = $entry[ 'line' ];
            }
            
            // Output
            $output .= "Called by: {$caller}\n";
            $output .= "File:      {$file}\n";
            $output .= "Line:      {$line}\n";
            $output .= "----------------------------------------\n";
        }
        return $output;
    }
}
