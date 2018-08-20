<?php
namespace PHP\Tests\TypesTest;

require_once( __DIR__ . '/../TypesData.php' );

use PHP\Types;
use PHP\Tests\TypesData;


/**
 * Tests the \PHP\Types\Type functionality
 */
class TypeTest extends \PHP\Tests\TestCase
{
    
    
    /***************************************************************************
    *                             Type->getAliases()
    ***************************************************************************/
    
    /**
     * Ensure Type->getAliases() returns the correct aliases
     */
    public function testGetAliasesReturnsCorrectAliases()
    {
        foreach ( TypesData::Get() as $data ) {
            $type  = self::getType( $data[ 'in' ] );
            $class = self::getClassName( $type );
            $this->assertEquals(
                $data[ 'out' ][ 'aliases' ],
                $type->getAliases()->toArray(),
                "{$class}->getAliases() did not return the correct aliases"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                             Type->getName()
    ***************************************************************************/
    
    /**
     * Ensure Type->getName() returns the correct name
     */
    public function testGetNameReturnsCorrectName()
    {
        foreach ( TypesData::Get() as $data ) {
            $type  = self::getType( $data[ 'in' ] );
            $class = self::getClassName( $type );
            $this->assertEquals(
                $data[ 'out' ][ 'name' ],
                $type->getName(),
                "{$class}->getName() did not return the correct name"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                                  UTILITIES
    ***************************************************************************/
    
    /**
     * Return the Type instance for the given data[ 'in' ] property
     *
     * @param array $dataIn The $data[ 'in' ] property
     * @return \PHP\Types\Type
     */
    private static function getType( array $dataIn ): \PHP\Types\Type
    {
        $type = null;
        if ( array_key_exists( 'value', $dataIn )) {
            $type = Types::GetByValue( $dataIn[ 'value' ] );
        }
        elseif ( !empty( $dataIn[ 'names'] )) {
            $type = Types::GetByName( $dataIn[ 'names' ][ 0 ] );
        }
        else {
            throw new \Exception( 'Malformed Type test data. Type query is missing.' );
        }
        return $type;
    }
}
