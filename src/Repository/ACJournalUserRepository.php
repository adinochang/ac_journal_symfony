<?php

namespace App\Repository;

use App\Entity\ACJournalUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ACJournalUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ACJournalUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ACJournalUser[]    findAll()
 * @method ACJournalUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ACJournalUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ACJournalUser::class);
    }

    // /**
    //  * @return ACJournalUser[] Returns an array of ACJournalUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ACJournalUser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
