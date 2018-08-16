<?php
namespace PHP;

/**
 * Lookup type information
 */
final class Types
{
    
    /**
     * List of type names mapped to their aliases
     *
     * @var string[]
     */
    private static $aliasMap = [
        'boolean' => [ 'bool' ],
        'double'  => [ 'float' ],
        'integer' => [ 'int' ]
    ];
    
    
    /**
     * Retrieve the type information by name
     *
     * @param string $name The type name
     * @return Types\Type
     */
    public static function GetByName( string $name ): Types\Type
    {
        // Variables
        $name    = trim( $name );
        $aliases = [];
        
        // Get the name and aliases
        if (( 'NULL' === $name ) || ( 'null' === $name )) {
            $name = 'null';
        }
        elseif ( class_exists( $name )) {
            $name = $name;
        }
        elseif ( function_exists( $name ) || ( 'function' === $name )) {
            $name = 'function';
        }
        elseif ( array_key_exists( $name, self::$aliasMap )) {
            $aliases = self::$aliasMap[ $name ];
        }
        elseif ( '' !== self::getNameByAlias( $name )) {
            $name    = self::getNameByAlias( $name );
            $aliases = self::$aliasMap[ $name ];
        }
        
        // Unknown type (http://php.net/manual/en/function.gettype.php)
        elseif ( !in_array( $name, [ 'array', 'string' ] )) {
            $name = 'unknown type';
        }
        
        // Return new type
        return new Types\Type( $name, $aliases );
    }
    
    
    /**
     * Retrieve the type information by value
     *
     * @param mixed $value The value to retrieve type information for
     * @return Types\Type
     */
    public static function GetByValue( $value ): Types\Type
    {
        $name = gettype( $value );
        if ( 'object' === $name ) {
            $name = get_class( $value );
        }
        return self::GetByName( $name );
    }
    
    
    /**
     * Try to lookup the type name by its alias
     *
     * @param  string $alias The type alias
     * @return string The name or an empty string if not found
     */
    private static function getNameByAlias( string $alias ): string
    {
        $name = '';
        foreach ( self::$aliasMap as $typeName => $aliases ) {
            if ( in_array( $alias, $aliases ) ) {
                $name = $typeName;
                break;
            }
        }
        return $name;
    }
}
