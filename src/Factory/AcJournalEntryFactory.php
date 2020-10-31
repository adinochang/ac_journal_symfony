<?php

namespace App\Factory;

use App\Entity\AcJournalEntry;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static AcJournalEntry|Proxy findOrCreate(array $attributes)
 * @method static AcJournalEntry|Proxy random()
 * @method static AcJournalEntry[]|Proxy[] randomSet(int $number)
 * @method static AcJournalEntry[]|Proxy[] randomRange(int $min, int $max)
 * @method AcJournalEntry|Proxy create($attributes = [])
 * @method AcJournalEntry[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class AcJournalEntryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(AcJournalEntry $acJournalEntry) {})
        ;
    }

    protected static function getClass(): string
    {
        return AcJournalEntry::class;
    }
}
