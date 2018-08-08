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
        $name      = strtolower( gettype( $value ) );
        $shortName = '';
        switch ( $name ) {
            case 'boolean':
                $shortName = 'bool';
                break;
            
            case 'integer':
                $shortName = 'int';
                break;
            
            case 'double':
                $shortName = 'float';
                break;
            
            case 'object':
                $name      = get_class( $value );
                $shortName = explode( '\\', $name );
                $shortName = array_pop( $shortName );
                break;
            
            default:
                break;
        }
        
        // Create and return a new type
        return new Types\Type( $name, $shortName );
    }
}
