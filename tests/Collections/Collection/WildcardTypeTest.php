<?php
namespace PHP\Tests\Collections\Types;

use PHP\Collections\Collection\WildcardType;


/**
 * Tests WildcardType
 */
class WildcardTypeTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Ensure WildcardType->equals() is true for anything
     **/
    public function testEqualsAlwaysReturnsTrue()
    {
        $values = [
            1,
            'string',
            true
        ];
        $type = new WildcardType();
        foreach ( $values as $value ) {
            $this->assertTrue(
                $type->equals( $value ),
                'WildcardType->equals() should always return true'
            );
        }
    }


    /**
     * Ensure WildcardType->getAliases() is empty
     **/
    public function testGetAliasesIsEmpty()
    {
        $this->assertEquals(
            0,
            ( new WildcardType() )->getAliases()->count(),
            'WildcardType->getAliases() should be empty'
        );
    }


    /**
     * Ensure WildcardType->getName() is an asterisk
     **/
    public function testGetNameIsAsterisk()
    {
        $this->assertEquals(
            '*',
            ( new WildcardType() )->getName(),
            'WildcardType->getName() should return an asterisk'
        );
    }


    /**
     * Ensure WildcardType->is() is true for anything
     **/
    public function testIsAlwaysReturnsTrue()
    {
        $typeNames = [
            'int',
            'string',
            'bool'
        ];
        $type = new WildcardType();
        foreach ( $typeNames as $typeName ) {
            $this->assertTrue(
                $type->is( $typeName ),
                'WildcardType->is() should always return true'
            );
        }
    }
}
