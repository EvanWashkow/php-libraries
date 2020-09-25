<?php
declare(strict_types=1);

namespace PHP\Collections\ByteArrayConverter;

/**
 * Modifies hash results using the Decorator pattern
 */
abstract class ByteArrayConverterDecorator implements IByteArrayConverter
{

    /** @var IByteArrayConverter $nextHasher The next Hasher in the sequence to execute */
    private $nextHasher;


    /**
     * Create a new Hasher Decorator
     * @param IByteArrayConverter $nextHasher The next Hasher in the sequence to execute
     */
    public function __construct(IByteArrayConverter $nextHasher)
    {
        $this->nextHasher = $nextHasher;
    }


    /**
     * Retrieve the next IHasher in the execution sequence
     * @return IByteArrayConverter
     *@internal Final as this should always return the value from the constructor.
     */
    final protected function getNextHasher(): IByteArrayConverter
    {
        return $this->nextHasher;
    }
}