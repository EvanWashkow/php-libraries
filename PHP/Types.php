<?php
namespace PHP;

/**
 * Lookup type information
 */
final class Types
{
    
    /**
     * Retrieve the type information for the given value
     *
     * @param mixed $value The value to retrieve type information for
     * @return Types\Type
     */
    public static function GetByValue( $value ): Types\Type
    {
        // Get and convert the name
        $name = gettype( $value );
        switch ( $name ) {
            case 'boolean':
                $name = 'bool';
                break;
            
            case 'integer':
                $name = 'int';
                break;
            
            case 'double':
                $name = 'float';
                break;
            
            case 'object':
                $name = get_class( $value );
                break;
            
            default:
                break;
        }
        
        // Create and return a new type
        return new Types\Type( $name );
    }
}
