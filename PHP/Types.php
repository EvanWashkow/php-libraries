<?php
namespace PHP;

/**
 * Lookup type information
 */
final class Types
{
    
    /**
     * undocumented class variable
     *
     * @var string
     */
    private static $shortNameMap = [
        'boolean' => 'bool',
        'double'  => 'float',
        'integer' => 'int'
    ];
    
    
    /**
     * Retrieve the type information by name
     *
     * @param string $name The type name
     * @return Types\Type
     */
    public static function GetByName( string $name ): Types\Type
    {
        // Sanitize the name
        $name = trim( $name );
        if ( '' === $name ) {
            $name = 'null';
        }
        
        // Get the name / short name
        $shortName = '';
        if ( 'NULL' === $name ) {
            $name = 'null';
        }
        elseif ( array_key_exists( $name, self::$shortNameMap )) {
            $shortName = self::$shortNameMap[ $name ];
        }
        elseif ( in_array( $name, self::$shortNameMap )) {
            $shortName = $name;
            $name      = array_search( $shortName, self::$shortNameMap );
        }
        elseif ( class_exists( $name )) {
            $shortName = explode( '\\', $name );
            $shortName = array_pop( $shortName );
        }
        
        // Return new type
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
