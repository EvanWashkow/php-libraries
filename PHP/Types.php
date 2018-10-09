<?php
namespace PHP;

use PHP\Types\Type;


/**
 * Lookup type information
 */
final class Types
{


    /***************************************************************************
    *                                  PROPERTIES
    ***************************************************************************/

    /** @var Type[] $cache Cache of type instances indexed by their name */
    private static $cache = [];
    
    /** @var string[] List of known type names mapped to their aliases */
    private static $knownTypes = [
        'array'  => [],
        'bool'   => [ 'boolean' ],
        'float'  => [ 'double' ],
        'int'    => [ 'integer' ],
        'string' => []
    ];

    /** @var Type $unknownType The unknown type definition */
    private static $unknownType = null;




    /***************************************************************************
    *                                 MAIN LOOKUP
    ***************************************************************************/
    
    
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

        // Query the type cache
        if ( self::isTypeCached( $name )) {
            $type = self::getCachedType( $name );
        }
        
        // Known system types
        elseif (( 'NULL' === $name ) || ( 'null' === $name )) {
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

        // Cache and return the type
        self::cacheType( $type );
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




    /***************************************************************************
    *                                  TYPE CACHE
    *
    * @internal Type caches connot use collections. Collections derive their
    * functionality from Types.
    ***************************************************************************/


    /**
     * Cache the Type for quicker retrieval later
     *
     * @param Type $type The type instance
     **/
    private static function cacheType( Type $type )
    {
        if ( self::GetUnknown()->getName() !== $type->getName() ) {
            self::$cache[ $type->getName() ] = $type;
        }
    }


    /**
     * Retrieve Type from cache
     *
     * @param string $name The type name
     * @return Type
     **/
    private static function getCachedType( string $name ): Type
    {
        return self::$cache[ $name ];
    }


    /**
     * Determine if a Type instance is cached
     *
     * @param string $name The type name
     * @return Type
     **/
    private static function isTypeCached( string $name ): bool
    {
        return array_key_exists( $name, self::$cache );
    }
}
