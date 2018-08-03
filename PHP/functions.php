<?php

/**
 * Determine if the variable is, or is derived from, the type
 *
 * @param mixed  $variable The variable
 * @param string $type     Type string to compare the variable's type with
 * @return bool
 */
function is( $variable, string $type ): bool
{
    // Variables
    $isOfType     = false;
    $variableType = gettype( $variable );
    
    // Evaluate
    if ( 'object' === $variableType ) {
        $isOfType = is_a( $variable, $type );
    }
    else {
        $isOfType = $variableType === $type;
    }
    return $isOfType;
}
