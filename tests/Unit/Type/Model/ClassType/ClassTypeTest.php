<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\ClassType;

use EvanWashkow\PhpLibraries\Exception\Logic\NotExistsException;
use EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\TestDefinition\TypeTestDefinition;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\ArrayType;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\BooleanType;
use EvanWashkow\PhpLibraries\Type\Model\ClassType\ClassType;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\FloatType;
use EvanWashkow\PhpLibraries\Type\Model\InterfaceType\InterfaceType;

/**
 * Tests the ClassType class
 */
final class ClassTypeTest extends TypeTestDefinition
{

    /**
     * Tests the constructor exception
     *
     * @dataProvider getConstructorExceptionTestData
     *
     * @param string $badClassName
     */
    public function testConstructorException(string $badClassName): void
    {
        $this->expectException(NotExistsException::class);
        new ClassType($badClassName);
    }

    public function getConstructorExceptionTestData(): array
    {
        return [
            'foobar' => ['foobar'],
            'Interface' => [\Iterator::class],
        ];
    }


    /**
     * @inheritDoc
     */
    public function getIsTestData(): array
    {
        $error            = new ClassType(\Error::class);
        $exception        = new ClassType(\Exception::class);
        $logicException   = new ClassType(\LogicException::class);
        $runtimeException = new ClassType(\RuntimeException::class);

        return [

            // Other Type instances
            'Error->is(ArrayType)' => [$error, new ArrayType(), false],
            'Exception->is(ArrayType)' => [$exception, new ArrayType(), false],
            'Error->is(BooleanType)' => [$error, new BooleanType(), false],
            'Exception->is(BooleanType)' => [$exception, new BooleanType(), false],
            'Error->is(FloatType)' => [$error, new FloatType(), false],
            'Exception->is(FloatType)' => [$exception, new FloatType(), false],

            // InterfaceType
            'Exception->is(InterfaceType(Throwable))' => [
                $exception,
                new InterfaceType(new \ReflectionClass(\Throwable::class)),
                true
            ],
            'Exception->is(InterfaceType(Iterator))' => [
                $exception,
                new InterfaceType(new \ReflectionClass(\Iterator::class)),
                false
            ],
            'Exception->is(InterfaceType(Traversable))' => [
                $exception,
                new InterfaceType(new \ReflectionClass(\Traversable::class)),
                false
            ],
            'Error->is(InterfaceType(Throwable))' => [
                $error,
                new InterfaceType(new \ReflectionClass(\Throwable::class)),
                true
            ],
            'Error->is(InterfaceType(Iterator))' => [
                $error,
                new InterfaceType(new \ReflectionClass(\Iterator::class)),
                false
            ],
            'Error->is(InterfaceType(Traversable))' => [
                $error,
                new InterfaceType(new \ReflectionClass(\Traversable::class)),
                false
            ],

            // ClassType instances
            'Error->is(ClassType(Error))' => [$error, $error, true],
            'Error->is(ClassType(Exception))' => [$error, $exception, false],
            'Exception->is(ClassType(Exception))' => [$exception, $exception, true],
            'Exception->is(ClassType(Error))' => [$exception, $error, false],
            'LogicException->is(ClassType(Exception))' => [$logicException, $exception, true],
            'Exception->is(ClassType(LogicException))' => [$exception, $logicException, false],
            'RuntimeException->is(ClassType(Exception))' => [$runtimeException, $exception, true],
            'Exception->is(ClassType(RuntimeException))' => [$exception, $runtimeException, false],
        ];
    }


    /**
     * @inheritDoc
     */
    public function getIsUnknownTypeNameTestData(): array
    {
        $exception = new ClassType(\Exception::class);
        return [
            'ClassType(Exception)' => [$exception],
        ];
    }


    /**
     * @inheritDoc
     */
    public function getIsValueOfTypeTestData(): array
    {
        $error            = new ClassType(\Error::class);
        $exception        = new ClassType(\Exception::class);
        $logicException   = new ClassType(\LogicException::class);
        $runtimeException = new ClassType(\RuntimeException::class);

        return [

            // Primitive value
            'Exception->isValueOfType([])' => [$exception, [], false],
            'Exception->isValueOfType(true)' => [$exception, true, false],
            'Exception->isValueOfType(1)' => [$exception, 1, false],
            'Exception->isValueOfType(8.7)' => [$exception, 8.7, false],

            // Object instance
            'Error->isValueOfType(Error)' => [$error, new \Error(), true],
            'Error->isValueOfType(Exception)' => [$error, new \Exception(), false],
            'Exception->isValueOfType(Exception)' => [$exception, new \Exception(), true],
            'Exception->isValueOfType(Error)' => [$exception, new \Error(), false],
            'Exception->isValueOfType(LogicException)' => [$exception, new \LogicException(), true],
            'Exception->isValueOfType(RuntimeException)' => [$exception, new \RuntimeException(), true],
            'LogicException->isValueOfType(Exception)' => [$logicException, new \Exception(), false],
            'RuntimeException->isValueOfType(Exception)' => [$runtimeException, new \Exception(), false],
        ];
    }


    /**
     * @inheritDoc
     */
    public function getNameTestData(): array
    {
        return [
            \Exception::class => [
                new ClassType(\Exception::class),
                \Exception::class
            ],
            \RuntimeException::class => [
                new ClassType(\RuntimeException::class),
                \RuntimeException::class
            ],
            \LogicException::class => [
                new ClassType(\LogicException::class),
                \LogicException::class
            ],
        ];
    }
}
