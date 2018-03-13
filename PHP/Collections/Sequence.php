<?php
namespace PHP\Collections;

use PHP\Collections\Sequence\iSequence;

/**
 * Defines a mutable, ordered set of indexed values
 *
 * This would have been named "List" had that not been reserved by PHP
 */
class Sequence extends \PHP\Object implements iSequence
{
    
    /**
     * List of values
     *
     * @var array
     */
    private $items;
    
    /**
     * Type requirement for all values
     *
     * @var string
     */
    private $type;
    
    
    public function __construct( string $type = '' )
    {
        $this->Clear();
        $this->type = $type;
    }
    
    
    public function Add( $value )
    {
        $index = null;
        if ( $this->isValueValidType( $value )) {
            $this->items[] = $value;
            $index         = $this->GetLastIndex();
        }
        return $index;
    }
    
    public function Clear()
    {
        return $this->items = [];
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
    
    public function GetFirstIndex(): int
    {
        return 0;
    }
    
    public function GetLastIndex(): int
    {
        return ( $this->Count() - 1 );
    }
    
    public function HasIndex( $index ): bool
    {
        return ( is( $index, 'integer' ) && array_key_exists( $index, $this->items ));
    }
    
    public function Loop( callable $function, &...$args )
    {
        $parameters = array_merge( [ $function ], $args );
        $iterable   = new Iterable( $this->items );
        return call_user_func_array( [ $iterable, 'Loop' ], $parameters );
    }
    
    public function Remove( $index )
    {
        unset( $this->items[ $index ] );
        $this->items = array_values( $this->items );
    }
    
    public function Update( $index, $value )
    {
        if ( $this->HasIndex( $index ) && $this->isValueValidType( $value )) {
            $this->items[ $index ] = $value;
        }
        else {
            $index = null;
        }
        return $index;
    }
    
    
    /**
     * Determine if the value meets the type requirements
     *
     * @param mixed $value The value to check
     * @return bool
     */
    private function isValueValidType( $value ): bool
    {
        return (( '' === $this->type ) || is( $value, $this->type ));
    }
}
