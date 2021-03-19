<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\Tests\Type\Model\TestDefinition\DynamicTypeTestDefinition;
use PHP\Type\Model\AnonymousType;
use PHP\Type\Model\ArrayType;
use PHP\Type\Model\ClassType;

/**
 * Tests the ClassType class
 */
final class ClassTypeTest extends DynamicTypeTestDefinition
{
    public function getIsTestData(): array
    {
        $error            = new ClassType(new \ReflectionClass(\Error::class));
        $exception        = new ClassType(new \ReflectionClass(\Exception::class));
        $logicException   = new ClassType(new \ReflectionClass(\LogicException::class));
        $runtimeException = new ClassType(new \ReflectionClass(\RuntimeException::class));

        /**
         * @todo Add more tests
         */
        return [

            /**
             * Type
             *
             * @todo Add more Type tests
             */
            'Exception->is(AnonymousType)' => [
                $exception,
                new AnonymousType(),
                false
            ],
            'Exception->is(ArrayType)' => [
                $exception,
                new ArrayType(),
                false
            ],

            /**
             * @todo Add InterfaceType
             */

            // ClassType
            'LogicException->is(ClassType(Exception))' => [
                $logicException,
                $exception,
                true
            ],
            'Exception->is(ClassType(LogicException))' => [
                $exception,
                $logicException,
                false
            ],
            'RuntimeException->is(ClassType(Exception))' => [
                $runtimeException,
                $exception,
                true
            ],
            'Exception->is(ClassType(RuntimeException))' => [
                $exception,
                $runtimeException,
                false
            ],

            // Primitive name
            'Exception->is(array)' => [
                $exception,
                'array',
                false
            ],
            'Exception->is(bool)' => [
                $exception,
                'bool',
                false
            ],
            'Exception->is(integer)' => [
                $exception,
                'integer',
                false
            ],
            'Exception->is(float)' => [
                $exception,
                'float',
                false
            ],

            // Interface name
            'Exception->is(Throwable::class)' => [
                $exception,
                \Throwable::class,
                true
            ],
            'Exception->is(Iterator::class)' => [
                $exception,
                \Iterator::class,
                false
            ],
            'Exception->is(Traversable::class)' => [
                $exception,
                \Traversable::class,
                false
            ],
            'Error->is(Throwable::class)' => [
                $error,
                \Throwable::class,
                true
            ],
            'Error->is(Iterator::class)' => [
                $error,
                \Iterator::class,
                false
            ],
            'Error->is(Traversable::class)' => [
                $error,
                \Traversable::class,
                false
            ],

            // Class name
            'LogicException->is(Exception::class)' => [
                $logicException,
                \Exception::class,
                true
            ],
            'Exception->is(LogicException::class)' => [
                $exception,
                \LogicException::class,
                false
            ],
            'RuntimeException->is(Exception::class)' => [
                $runtimeException,
                \Exception::class,
                true
            ],
            'Exception->is(RuntimeException::class)' => [
                $exception,
                \RuntimeException::class,
                false
            ],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        $exception        = new ClassType(new \ReflectionClass(\Exception::class));
        $logicException   = new ClassType(new \ReflectionClass(\LogicException::class));
        $runtimeException = new ClassType(new \ReflectionClass(\RuntimeException::class));

        return [

            // Primitive type
            'Exception->isValueOfType([])' => [
                $exception,
                [],
                false
            ],
            'Exception->isValueOfType(true)' => [
                $exception,
                true,
                false
            ],
            'Exception->isValueOfType(1)' => [
                $exception,
                1,
                false
            ],
            'Exception->isValueOfType(8.7)' => [
                $exception,
                8.7,
                false
            ],

            // Class type
            'Exception->isValueOfType(LogicException)' => [
                $exception,
                new \LogicException(),
                true
            ],
            'Exception->isValueOfType(RuntimeException)' => [
                $exception,
                new \RuntimeException(),
                true
            ],
            'LogicException->isValueOfType(Exception)' => [
                $logicException,
                new \Exception(),
                false
            ],
            'RuntimeException->isValueOfType(Exception)' => [
                $runtimeException,
                new \Exception(),
                false
            ],
        ];
    }


    /**
     * Tests getName(), ensuring the parent constructor is called
     *
     * @dataProvider getGetNameTestData
     *
     * @param string $className
     *
     * @throws \ReflectionException
     */
    public function testGetName(string $className): void
    {
        $this->assertEquals(
            $className,
            (new ClassType(new \ReflectionClass($className)))->getName(),
            ClassType::class . '->getName() did not return the expected value'
        );
    }

    public function getGetNameTestData(): array
    {
        return [
            \Exception::class => [\Exception::class],
            \RuntimeException::class => [\RuntimeException::class],
            \LogicException::class => [\LogicException::class],
        ];
    }
}
