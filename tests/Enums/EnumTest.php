<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\ObjectClass;
use PHP\Tests\Enums\EnumTest\MixedEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum class
 */
class EnumTest extends TestCase
{

    /**
     * Test class inheritance
     */
    public function testIsObjectClass()
    {
        $this->assertInstanceOf(
            ObjectClass::class,
            new MixedEnum( MixedEnum::NUMBERS ),
            'Enum is not an ObjectClass'
        );
    }


    /**
     * Test the construction of Enums
     * 
     * @dataProvider getTestConstructorData()
     */
    public function testConstructor( \Closure $callback )
    {
        $this->assertInstanceOf(
            Enum::class,
            $callback(),
            'Enum Constructor failed unexpectedly'
        );
    }

    public function getTestConstructorData(): array
    {
        return [
            'new MixedEnum( MixedEnum::STRING )' => [function() {
                return new MixedEnum( MixedEnum::STRING );
            }],
            'new MixedEnum( MixedEnum::NUMBERS )' => [function() {
                return new MixedEnum( MixedEnum::NUMBERS );
            }],
            'new MixedEnum( MixedEnum::ARRAY )' => [function() {
                return new MixedEnum( MixedEnum::ARRAY );
            }]
        ];
    }


    /**
     * Test the DomainException when constructing an Enum
     * 
     * @dataProvider getTestConstructorExceptionData()
     * @expectedException \DomainException
     */
    public function testConstructorException( \Closure $callback )
    {
        $callback();
    }

    public function getTestConstructorExceptionData(): array
    {
        return [
            'new MixedEnum( MixedEnum::NUMBERS )' => [function() {
                return new MixedEnum( "MixedEnum::NUMBERS" );
            }],
            'new MixedEnum( MixedEnum::ARRAY )' => [function() {
                $stringArray = [];
                foreach ( MixedEnum::ARRAY as $value ) {
                    $stringArray[] = "$value";
                }
                return new MixedEnum( $stringArray );
            }]
        ];
    }
}