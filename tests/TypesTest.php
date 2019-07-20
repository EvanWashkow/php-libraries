<?php
namespace PHP\Tests;

use PHP\Types;
use PHP\Collections\Sequence;

/**
 * Tests the \PHP\Types functionality
 */
class TypesTest extends TestCase
{
    
    
    /***************************************************************************
    *                              Types::GetByName()
    ***************************************************************************/
    
    
    /**
     * Ensure Types::GetByName() returns type with the same name
     * 
     * @dataProvider getGetByNameData()
     * 
     * @param string $typeName Type name to pass to GetByName()
     * @param string $expected Expected type name from Type->getName()
     */
    public function testGetByName( string $typeName, string $expected )
    {
        $this->assertEquals(
            $expected,
            Types::GetByName( $typeName )->getName(),
            "Type->getName() did not return the correct name"
        );
    }


    /**
     * Provides test data for GetByName() test
     * 
     * @return array
     */
    public function getGetByNameData(): array
    {
        return [
            [ 'array',                         'array' ],
            [ 'boolean',                       'bool' ],
            [ 'integer',                       'int' ],
            [ 'function',                      'function' ],
            [ 'substr',                        'function' ],
            [ 'double',                        'float' ],
            [ 'null',                          'null' ],
            [ 'string',                        'string' ],
            [ 'Iterator',                      'Iterator' ],
            [ 'PHP\\Collections\\Sequence',    'PHP\\Collections\\Sequence' ]
        ];
    }


    /**
     * Retrieving type 
     * 
     * @expectedException \PHP\Exceptions\NotFoundException
     */
    public function testGetByUnknownName()
    {
        Types::GetByName( 'foobar' );
    }
    
    
    
    
    /***************************************************************************
    *                              Types::GetByValue()
    ***************************************************************************/
    
    
    /**
     * Ensure Types::GetByValue() returns a `Type` instance
     */
    public function testGetByValueReturnsType()
    {
        $this->assertInstanceOf(
            'PHP\\Types\\Models\\Type',
            Types::GetByValue( null ),
            'Expected Types::GetByValue() to return a PHP\\Types\\Models\\Type instance'
        );
    }
    
    
    /**
     * Ensure Types::GetByValue() returns type with the same name
     */
    public function testGetByValueReturnsCorrectName()
    {
        // Ensure each type returns its expected type name
        foreach ( self::getTypeNameValueMap() as $name => $value ) {
            $type = Types::GetByValue( $value );
            $this->assertEquals(
                $name,
                $type->getName(),
                "Type->getName() did not return the correct name"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                              Types::GetUnknownType()
    ***************************************************************************/
    
    
    /**
     * Ensure Types::GetUnknownType() returns a `Type` instance
     */
    public function testGetUnknownReturnsType()
    {
        $this->assertInstanceOf(
            'PHP\\Types\\Models\\Type',
            Types::GetUnknownType(),
            'Expected Types::GetUnknownType() to return a PHP\\Types\\Models\\Type instance'
        );
    }


    /**
     * Ensure Types::GetUnknownType() returns an type with an "unknown type" name
     **/
    public function testGetUnknownReturnsUnknownTypeName()
    {
        $this->assertEquals(
            'unknown type',
            Types::GetUnknownType()->getName(),
            'Expected Types::GetUnkown() to return a type with name "unknown type"'
        );
    }
    
    
    
    
    /***************************************************************************
    *                 Types::GetByName() == Types::GetByValue()
    ***************************************************************************/
    
    
    /**
     * Ensure all Types::GetBy methods return the same type data
     */
    public function testGetByMethodsReturnSameResults()
    {
        foreach ( self::getTypeNameValueMap() as $name => $value ) {
            $this->assertEquals(
                Types::GetByName( $name ),
                Types::GetByValue( $value ),
                "Expected all Types::GetBy methods to return the same type data"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                                    DATA
    ***************************************************************************/
    
    
    /**
     * Retrieve sample lookup data of type names mapped to their values
     *
     * @return array
     **/
    private static function getTypeNameValueMap(): array
    {
        return [
            'array'         => [],
            'bool'          => false,
            'int'           => 1,
            'float'         => 1.0,
            'null'          => null,
            'string'        => 'foobar',
            Sequence::class => new Sequence( '*' ),
        ];
    }
}
