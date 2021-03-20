<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model;

use PHP\Tests\Type\Model\TestDefinition\DynamicTypeTestDefinition;
use PHP\Type\Model\AnonymousType;
use PHP\Type\Model\ArrayType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\ClassType;
use PHP\Type\Model\FloatType;

/**
 * Tests the ClassType class
 */
final class ClassTypeTest extends DynamicTypeTestDefinition
{
    public function getGetNameTestData(): array
    {
        return [
            \Exception::class => [
                new ClassType(new \ReflectionClass(\Exception::class)),
                \Exception::class
            ],
            \RuntimeException::class => [
                new ClassType(new \ReflectionClass(\RuntimeException::class)),
                \RuntimeException::class
            ],
            \LogicException::class => [
                new ClassType(new \ReflectionClass(\LogicException::class)),
                \LogicException::class
            ],
        ];
    }


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

            // Other Type instances
            'Error->is(ArrayType)' => [
                $error,
                new ArrayType(),
                false
            ],
            'Exception->is(ArrayType)' => [
                $exception,
                new ArrayType(),
                false
            ],
            'Error->is(BooleanType)' => [
                $error,
                new BooleanType(),
                false
            ],
            'Exception->is(BooleanType)' => [
                $exception,
                new BooleanType(),
                false
            ],
            'Error->is(FloatType)' => [
                $error,
                new FloatType(),
                false
            ],
            'Exception->is(FloatType)' => [
                $exception,
                new FloatType(),
                false
            ],

            /**
             * @todo Add InterfaceType
             */

            /**
             * ClassType instances
             *
             * @todo Add same checks for the same type (see InterfaceType)
             */
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

            // Primitive names
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

            // Interface names
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

            /**
             * Class names
             *
             * @todo Add same checks for the same type (see InterfaceType)
             */
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

            // Primitive value
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

            // Object instance
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
}
