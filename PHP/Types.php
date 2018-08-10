<?php
namespace PHP;

/**
 * Lookup type information
 */
final class Types
{
    
    /**
     * List of basic system types mapped to their short names
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
        // Get the name / short name
        $name      = trim( $name );
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
        elseif ( function_exists( $name )) {
            $shortName = $name;
            $name      = 'function';
        }
        elseif ( 'function' === $name ) {
            $name = 'function';
        }
        
        // Unknown type (http://php.net/manual/en/function.gettype.php)
        elseif ( !in_array( $name, [ 'array', 'string' ] )) {
            $name = 'unknown type';
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
