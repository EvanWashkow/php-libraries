<?php
namespace PHP;

use PHP\Collections\IDictionary;

/**
 * Specifications for a cache of values
 */
interface ICache extends IDictionary
{
    
    /**
     * Has this cache been marked complete?
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     *
     * @return bool
     */
    public function isComplete(): bool;
    
    /**
     * Mark cache as complete
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     */
    public function markComplete();
    
    /**
     * Mark cache as incomplete
     *
     * Useful for flagging an interative cache as "incomplete", meaning there
     * are still items to fetch
     */
    public function markIncomplete();
}
