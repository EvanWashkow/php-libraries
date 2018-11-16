<?php
namespace PHP;

use PHP\Types\Models\Type;
use PHP\Types\TypeNames;

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
        TypeNames::ARRAY  => [],
        TypeNames::BOOL   => [ 'boolean' ],
        TypeNames::FLOAT  => [ 'double' ],
        TypeNames::INT    => [ 'integer' ],
        TypeNames::NULL   => [],
        TypeNames::STRING => []
    ];




    /***************************************************************************
    *                                 MAIN LOOKUP
    ***************************************************************************/
    
    
    /**
     * Retrieve the type information by name
     *
     * @param string $name The type name
     * @return Type
     */
    public static function GetByName( string $name ): Type
    {
        // Variables
        $name = trim( $name );
        $type = null;

        // Query type cache
        if ( self::isCached( $name )) {
            $type = self::getCache( $name );
        }

        // Find type
        else {

            // Known system types
            if ( array_key_exists( $name, self::$knownTypes )) {
                $aliases = self::$knownTypes[ $name ];
                $type    = new Type( $name, $aliases );
            }
            elseif ( '' !== self::getNameByAlias( $name )) {
                $name    = self::getNameByAlias( $name );
                $aliases = self::$knownTypes[ $name ];
                $type    = new Type( $name, $aliases );
            }
            
            // Callable types
            elseif ( TypeNames::CALLABLE === $name ) {
                $type = new Types\Models\CallableBaseType();
            }
            elseif ( TypeNames::FUNCTION === $name ) {
                $type = new Types\Models\FunctionType();
            }
            elseif ( function_exists( $name )) {
                $function = new \ReflectionFunction( $name );
                $type     = new Types\Models\CallableFunctionType( $function );
            }
            
            // Class and interface types
            elseif ( interface_exists( $name )) {
                $class = new \ReflectionClass( $name );
                $type  = new Types\Models\InterfaceType( $class );
            }
            elseif ( class_exists( $name )) {
                $class = new \ReflectionClass( $name );
                $type  = new Types\Models\ClassType( $class );
            }

            // Unknown type
            else {
                $type = self::GetUnknownType();
            }

            // Cache the type
            self::setCache( $type );
        }
        
        // Return the type
        return $type;
    }
    
    
    /**
     * Retrieve the type information by value
     *
     * @param mixed $value The value to retrieve type information for
     * @return Type
     */
    public static function GetByValue( $value ): Type
    {
        $name = gettype( $value );

        /**
         * "NULL" is not a type: it is a value. "null" is the type.
         *
         * See: http://php.net/manual/en/language.types.null.php
         */ 
        if ( 'NULL' === $name ) {
            $name = TypeNames::NULL;
        }

        // Get class of objects
        elseif ( 'object' === $name ) {
            $name = get_class( $value );
        }
        return self::GetByName( $name );
    }


    /**
     * Retrieve unknown type
     *
     * @return Type
     **/
    public static function GetUnknownType(): Type
    {
        // The unknown type name (http://php.net/manual/en/function.gettype.php)
        $name = 'unknown type';

        // Get / cache the unknown type
        $type = null;
        if ( self::isCached( $name ) ) {
            $type = self::getCache( $name );
        }
        else {
            $type = new Type( TypeNames::UNKNOWN );
            self::setCache( $type );
        }

        // Return the unknown type
        return $type;
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
    private static function setCache( Type $type )
    {
        $name = $type->getName();
        if (
            $type->is( TypeNames::FUNCTION ) &&
            ( '' !== $type->getFunctionName() )
        ) {
            $name = $type->getFunctionName();
        }
        self::$cache[ $name ] = $type;
    }


    /**
     * Retrieve Type from cache
     *
     * @param string $name The type name
     * @return Type
     **/
    private static function getCache( string $name ): Type
    {
        return self::$cache[ $name ];
    }


    /**
     * Determine if a Type instance is cached
     *
     * @param string $name The type name
     * @return Type
     **/
    private static function isCached( string $name ): bool
    {
        return array_key_exists( $name, self::$cache );
    }
}
