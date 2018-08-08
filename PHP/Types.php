<?php
namespace PHP;

/**
 * Lookup type information
 */
final class Types
{
    
    
    /**
     * Retrieve the type information by name
     *
     * @param string $name The type name
     * @return Types\Type
     */
    public static function GetByName( string $name ): Types\Type
    {
        $name      = trim( $name );
        $shortName = '';
        if ( 'boolean' === $name ) {
            $shortName = 'bool';
        }
        elseif ( 'double' === $name ) {
            $shortName = 'float';
        }
        elseif ( 'integer' === $name ) {
            $shortName = 'int';
        }
        elseif ( 'NULL' === $name ) {
            $name = 'null';
        }
        elseif ( class_exists( $name )) {
            $shortName = explode( '\\', $name );
            $shortName = array_pop( $shortName );
        }
        return new Types\Type( $name, $shortName );
    }
    
    
    /**
     * Retrieve the type information by value
     *
     * @param mixed $value The value to retrieve type information for
     * @return Types\Type
     */
    public static function GetByValue( $value ): Types\Type
    {
        $name = strtolower( gettype( $value ) );
        if ( 'object' === $name ) {
            $name = get_class( $value );
        }
        return self::GetByName( $name );
    }
}
