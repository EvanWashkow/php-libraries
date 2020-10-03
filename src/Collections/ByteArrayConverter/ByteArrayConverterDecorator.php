<?php
declare(strict_types=1);

namespace PHP\Collections\ByteArrayConverter;

/**
 * Modifies the Byte Array conversion process using the Decorator pattern
 */
abstract class ByteArrayConverterDecorator implements IByteArrayConverter
{

    /** @var IByteArrayConverter $nextConverter The next Byte Array Converter in the execution sequence */
    private $nextConverter;


    /**
     * Create a new Byte Array Converter Decorator
     *
     * @param IByteArrayConverter $nextConverter The next Byte Array Converter in the execution sequence
     */
    public function __construct(IByteArrayConverter $nextConverter)
    {
        $this->nextConverter = $nextConverter;
    }


    /**
     * Retrieve the next Byte Array Converter in the execution sequence
     *
     * @return IByteArrayConverter
     * @internal Final as this should always return the value from the constructor.
     */
    final protected function getNextConverter(): IByteArrayConverter
    {
        return $this->nextConverter;
    }
}