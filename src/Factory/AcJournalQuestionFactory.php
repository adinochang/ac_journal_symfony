<?php

namespace App\Factory;

use App\Entity\AcJournalQuestion;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static AcJournalQuestion|Proxy findOrCreate(array $attributes)
 * @method static AcJournalQuestion|Proxy random()
 * @method static AcJournalQuestion[]|Proxy[] randomSet(int $number)
 * @method static AcJournalQuestion[]|Proxy[] randomRange(int $min, int $max)
 * @method AcJournalQuestion|Proxy create($attributes = [])
 * @method AcJournalQuestion[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class AcJournalQuestionFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'label' => self::faker()->sentence,
            'required' => 1,
            'enabled' => 1,
            'created_at' => new \DateTime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(AcJournalQuestion $acJournalQuestion) {})
        ;
    }

    protected static function getClass(): string
    {
        return AcJournalQuestion::class;
    }
}
