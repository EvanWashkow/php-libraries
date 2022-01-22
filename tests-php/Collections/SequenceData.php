<?php

namespace PHP\Tests;

use PHP\Collections\Sequence;

require_once __DIR__.'/CollectionsTestData.php';

/**
 * Sequence test data.
 */
final class SequenceData
{
    /**
     * Retrieve test instances, indexed by type.
     */
    public static function Get(): array
    {
        $instances = [];
        foreach (CollectionsTestData::Get() as $type => $values) {
            $sequenceType = (('' === $type) ? '*' : $type);
            $sequence = new Sequence($sequenceType);
            foreach ($values as $value) {
                $sequence->add($value);
            }

            $instances[$type] = [];
            $instances[$type][] = new Sequence($sequenceType);
            $instances[$type][] = $sequence;
        }

        return $instances;
    }

    // OLD

    /**
     * Retrieve old test data.
     */
    public static function GetOld(): array
    {
        $sequences = [];
        foreach (SequenceData::Get() as $type => $_sequences) {
            foreach ($_sequences as $sequence) {
                $sequences[] = $sequence;
            }
        }

        return $sequences;
    }

    /**
     * Retrieve old typed data.
     *
     * @return array
     */
    public static function GetOldTyped()
    {
        $sequences = [];
        foreach (SequenceData::Get() as $type => $_sequences) {
            if (in_array($type, ['', 'integer'])) {
                continue;
            }
            foreach ($_sequences as $sequence) {
                $sequences[] = $sequence;
            }
        }

        return $sequences;
    }

    /**
     * Retrieve old mixed data.
     *
     * @return array
     */
    public static function GetOldMixed()
    {
        $sequences = [];
        foreach (SequenceData::Get() as $type => $_sequences) {
            if ('' !== $type) {
                continue;
            }
            foreach ($_sequences as $sequence) {
                $sequences[] = $sequence;
            }
        }

        return $sequences;
    }

    // DUPLICATES

    /**
     * Retrieves duplicate test data by appending the reverse with itself.
     */
    public static function GetDuplicates(): array
    {
        $duplicates = [];
        foreach (CollectionsTestData::Get() as $type => $values) {
            $sequence = new Sequence($type);
            foreach ($values as $value) {
                $sequence->add($value);
            }
            foreach (array_reverse($values) as $value) {
                $sequence->add($value);
            }
            $duplicates[$type][] = $sequence;
        }

        return $duplicates;
    }
}
