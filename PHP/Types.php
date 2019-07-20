<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Exceptions\NotFoundException;
use PHP\Types\Models\Type;
use PHP\Types\TypeNames;
use PHP\Types\Models\FunctionType;

/**
 * Lookup type information
 * 
 * Callables are not types. They evaluate variables at runtime using reflection,
 * to determine if they reference a function. For example, 'substr' is callable,
 * but 'foobar' is not. Both are of the string type, but one is "callable" and
 * the other is not.
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
        TypeNames::BOOL   => [ TypeNames::BOOLEAN ],
        TypeNames::FLOAT  => [ TypeNames::DOUBLE ],
        TypeNames::INT    => [ TypeNames::INTEGER ],
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
     * @throws NotFoundException
     */
    public static function GetByName( string $name ): Type
    {
        // Variables
        $type = null;

        // Query type cache
        if ( self::isTypeCached( $name )) {
            $type = self::getTypeFromCache( $name );
        }

        // Find type
        else {

            // Known system types
            if ( array_key_exists( $name, self::$knownTypes )) {
                $aliases = self::$knownTypes[ $name ];
                $type    = new Type( $name, $aliases );
            }
            elseif ( '' !== ( $primaryName = self::getNameByAlias( $name ) )) {
                $aliases = self::$knownTypes[ $primaryName ];
                $type    = new Type( $primaryName, $aliases );
            }
            
            // Function types
            elseif ( TypeNames::FUNCTION === $name ) {
                $type = new Types\Models\FunctionBaseType();
            }
            elseif ( function_exists( $name )) {
                $function = new \ReflectionFunction( $name );
                $type     = new FunctionType( $function );
            }
            
            // Class and interface types
            elseif ( interface_exists( $name )) {
                $type = new Types\Models\InterfaceType(
                    new \ReflectionClass( $name )
                );
            }
            elseif ( class_exists( $name )) {
                $type = new Types\Models\ClassType(
                    new \ReflectionClass( $name )
                );
            }

            // Throw Exception. Type does not exist.
            else {
                throw new NotFoundException( "Type \"{$name}\" does not exist." );
            }

            // Cache the type
            self::addTypeToCache( $type );
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
        $type = NULL;
        if ( self::isTypeCached( TypeNames::UNKNOWN ) ) {
            $type = self::getTypeFromCache( TypeNames::UNKNOWN );
        }
        else {
            $type = new Type( TypeNames::UNKNOWN );
            self::addTypeToCache( $type );
        }
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
    private static function addTypeToCache( Type $type )
    {
        // Cache by the primary name
        $name = $type->getName();
        if ( is_a( $type, FunctionType::class )) {
            $name = $type->getFunctionName();
        }
        self::$cache[ $name ] = $type;

        // Cache by any aliases
        if ( array_key_exists( $name, self::$knownTypes )) {
            foreach ( self::$knownTypes[ $name ] as $alias ) {
                self::$cache[ $alias ] = $type;
            }
        }
    }


    /**
     * Retrieve Type from cache
     *
     * @param string $name The type name
     * @return Type
     **/
    private static function getTypeFromCache( string $name ): Type
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
