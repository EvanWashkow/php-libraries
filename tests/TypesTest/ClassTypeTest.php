<?php
namespace PHP\Tests\TypesTest;

use PHP\Types\Models\ClassType;
use PHP\Types;


/**
 * Tests the \PHP\Types\Models\ClassType functionality
 */
class ClassTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                                 TYPE CHECK
    ***************************************************************************/


    /**
     * Ensure that a type lookup returns a ClassType instance
     **/
    public function testTypesLookup()
    {
        $this->assertInstanceOf(
            ClassType::class,
            Types::GetByName( 'ReflectionClass' ),
            'Types lookup should return a ClassType instance when given a class name'
        );
    }




    /***************************************************************************
    *                            ClassType->getName()
    *
    * This was already tested when testing type lookup in Types Test. Nothing to
    * do here.
    ***************************************************************************/
}
