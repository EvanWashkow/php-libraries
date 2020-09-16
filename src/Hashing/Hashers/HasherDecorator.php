<?php
declare(strict_types=1);

namespace PHP\Hashing\Hashers;

/**
 * Modifies hash results using the Decorator pattern
 */
abstract class HasherDecorator implements IHasher
{

    /** @var IHasher $nextHasher The next Hasher in the sequence to execute */
    private $nextHasher;


    /**
     * Create a new Hasher Decorator
     * @param IHasher $nextHasher The next Hasher in the sequence to execute
     */
    public function __construct(IHasher $nextHasher)
    {
        $this->nextHasher = $nextHasher;
    }


    /**
     * Retrieve the next IHasher in the execution sequence
     * @internal Final as this should always return the value from the constructor.
     * @return IHasher
     */
    final protected function getNextHasher(): IHasher
    {
        return $this->nextHasher;
    }
}