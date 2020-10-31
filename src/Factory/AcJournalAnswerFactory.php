<?php

namespace App\Factory;

use App\Entity\AcJournalAnswer;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static AcJournalAnswer|Proxy findOrCreate(array $attributes)
 * @method static AcJournalAnswer|Proxy random()
 * @method static AcJournalAnswer[]|Proxy[] randomSet(int $number)
 * @method static AcJournalAnswer[]|Proxy[] randomRange(int $min, int $max)
 * @method AcJournalAnswer|Proxy create($attributes = [])
 * @method AcJournalAnswer[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class AcJournalAnswerFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'answer_text' => implode(PHP_EOL, self::faker()->paragraphs(random_int(3, 15))),
            'created_at' => new \DateTime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(AcJournalAnswer $acJournalAnswer) {})
        ;
    }

    protected static function getClass(): string
    {
        return AcJournalAnswer::class;
    }
}
