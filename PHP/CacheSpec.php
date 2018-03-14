<?php
namespace PHP;

use PHP\Collections\DictionarySpec;

/**
 * Specifications for a cache of values
 */
interface CacheSpec extends DictionarySpec
{
    
    /**
     * Has this cache been marked complete?
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     *
     * @return bool
     */
    public function IsComplete();
    
    /**
     * Mark cache as complete
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     */
    public function MarkComplete();
    
    /**
     * Mark cache as incomplete
     *
     * Useful for flagging an interative cache as "incomplete", meaning there
     * are still items to fetch
     */
    public function MarkIncomplete();
}
