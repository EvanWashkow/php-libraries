<?php
namespace PHP;

use PHP\Types\Type;


/**
 * Lookup type information
 */
final class Types
{
    
    /**
     * List of known type names mapped to their aliases
     *
     * @var string[]
     */
    private static $knownTypes = [
        'array'  => [],
        'bool'   => [ 'boolean' ],
        'float'  => [ 'double' ],
        'int'    => [ 'integer' ],
        'string' => []
    ];

    /** @var Type $unknownType The unknown type definition */
    private static $unknownType = null;
    
    
    /**
     * Retrieve the type information by name
     *
     * @param string $name The type name
     * @return Types\Type
     */
    public static function GetByName( string $name ): Types\Type
    {
        // Sanitize parameter
        $name = trim( $name );
        
        // The type instance to return
        $type = null;
        
        // Known system types
        if (( 'NULL' === $name ) || ( 'null' === $name )) {
            $type = new Types\Type( 'null' );
        }
        elseif ( array_key_exists( $name, self::$knownTypes )) {
            $aliases = self::$knownTypes[ $name ];
            $type    = new Types\Type( $name, $aliases );
        }
        elseif ( '' !== self::getNameByAlias( $name )) {
            $name    = self::getNameByAlias( $name );
            $aliases = self::$knownTypes[ $name ];
            $type    = new Types\Type( $name, $aliases );
        }
        
        // Class and interface types
        elseif ( interface_exists( $name )) {
            $class = new \ReflectionClass( $name );
            $type  = new Types\InterfaceType( $class );
        }
        elseif ( class_exists( $name )) {
            $class = new \ReflectionClass( $name );
            $type  = new Types\ClassType( $class );
        }
        
        // Function type
        elseif ( 'function' === $name ) {
            $type = new Types\FunctionType();
        }
        elseif ( function_exists( $name )) {
            $function = new \ReflectionFunction( $name );
            $type     = new Types\FunctionReferenceType( $function );
        }
        
        // Unknown type
        else {
            $type = self::GetUnknown();
        }
        
        // Return the type
        return $type;
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
     * Retrieve unknown type
     *
     * http://php.net/manual/en/function.gettype.php
     *
     * @return Type
     **/
    public static function GetUnknown(): Type
    {
        if ( self::$unknownType === null ) {
            self::$unknownType = new Type( 'unknown type' );
        }
        return self::$unknownType;
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
        foreach ( self::$knownTypes as $typeName => $aliases ) {
            if ( in_array( $alias, $aliases ) ) {
                $name = $typeName;
                break;
            }
        }
        return $name;
    }
}
