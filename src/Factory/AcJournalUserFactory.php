<?php

namespace App\Factory;

use App\Entity\AcJournalUser;
use App\Repository\AcJournalUserRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method static AcJournalUser|Proxy findOrCreate(array $attributes)
 * @method static AcJournalUser|Proxy random()
 * @method static AcJournalUser[]|Proxy[] randomSet(int $number)
 * @method static AcJournalUser[]|Proxy[] randomRange(int $min, int $max)
 * @method static AcJournalUserRepository|RepositoryProxy repository()
 * @method AcJournalUser|Proxy create($attributes = [])
 * @method AcJournalUser[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class AcJournalUserFactory extends ModelFactory
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->passwordEncoder = $passwordEncoder;
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->name,
            'created_at' => new \DateTime(),
        ];
    }

    protected function initialize(): self
    {
        return $this->afterInstantiate(function(AcJournalUser $user) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        });
    }

    protected static function getClass(): string
    {
        return AcJournalUser::class;
    }
}
