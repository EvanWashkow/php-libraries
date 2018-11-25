<?php
namespace PHP\Types\Models;

/**
 * Defines a type that can be executed as a function
 */
final class CallableType extends CallableBaseType
{

    /** @var \ReflectionFunctionAbstract $reflectionFunctionAbstract Reflection of the callable instance */
    private $reflectionFunctionAbstract;
    
    
    /**
     * Create a new callable type instance
     *
     * @param \ReflectionFunctionAbstract $reflectionFunctionAbstract Reflection of the callable instance
     */
    public function __construct(
        \ReflectionFunctionAbstract $reflectionFunctionAbstract
    ) {
        parent::__construct();
        $this->reflectionFunctionAbstract = $reflectionFunctionAbstract;
    }
}
