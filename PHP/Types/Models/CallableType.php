<?php
namespace PHP\Types\Models;

/**
 * Defines a type that can be executed as a function
 */
final class CallableType extends CallableBaseType
{

    /** @var \ReflectionFunction $reflection Reflection of the callable instance */
    private $reflection = null;
    
    
    /**
     * Create a new callable type instance
     *
     * @param \ReflectionFunction $reflection Reflection of the callable instance
     */
    public function __construct( \ReflectionFunction $reflection )
    {
        parent::__construct();
        $this->reflection = $reflection;
    }
}
