<?php
namespace PHP\Collections;

/**
 * Defines a mutable, unordered set of indexed values
 */
class Dictionary extends \PHP\Object implements Dictionary\iDictionary
{
    
    /**
     * The set of indexed values
     *
     * @var array
     */
    private $items;
    
    /**
     * Specifies the type requirement for all indexes
     *
     * @var string
     */
    private $indexType;
    
    /**
     * Specifies the type requirement for all values
     *
     * @var string
     */
    private $valueType;
    
    
    public function __construct( string $indexType = '', string $valueType = '' )
    {
        // Abort. Neither index nor value can be null.
        if ( 'null' === strtolower( $indexType )) {
            throw new \Exception( 'Dictionary indexes cannot be NULL' );
        }
        elseif ( 'null' === strtolower( $valueType )) {
            throw new \Exception( 'Dictionary values cannot be NULL' );
        }
        
        // Initialize properties
        $this->Clear();
        $this->indexType = $indexType;
        $this->valueType = $valueType;
    }
    
    
    public function Add( $index, $value )
    {
        if ( $this->HasIndex( $index )) {
            $index = null;
        }
        else {
            $index = $this->Update( $index, $value );
        }
        return $index;
    }
    
    
    public function Clear()
    {
        $this->items = [];
    }
    
    
    public function ConvertToArray(): array
    {
        return $this->items;
    }
    
    
    public function Count(): int
    {
        return count( $this->items );
    }
    
    
    public function Get( $index, $defaultValue = null )
    {
        $value = $defaultValue;
        if ( $this->HasIndex( $index )) {
            $value = $this->items[ $index ];
        }
        return $value;
    }
    
    
    public function HasIndex( $index ): bool
    {
        return (
            is( $index, $this->indexType ) &&
            array_key_exists( $index, $this->items )
        );
    }
    
    
    public function Loop( callable $function, &...$args )
    {
        foreach ( $this->items as $index => $value ) {
            
            // Add index and value the callback function parameters
            $parameters = array_merge(
                [
                    $index,
                    $value
                ],
                $args
            );
            
            // Execute the callback function, exiting when a non-null value is returned
            $result = call_user_func_array( $function, $parameters );
            if ( null !== $result ) {
                return $result;
            }
        }
    }
    
    
    public function Remove( $index )
    {
        if ( $this->HasIndex( $index )) {
            unset( $this->items[ $index ] );
        }
    }
    
    
    public function Update( $index, $value )
    {
        if (
            (( '' === $this->indexType ) || is( $index, $this->indexType )) &&
            (( '' === $this->valueType ) || is( $value, $this->valueType ))
        ) {
            $this->items[ $index ] = $value;
        }
        else {
            $index = null;
        }
        return $index;
    }
}
