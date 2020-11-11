<?php

namespace App\Repository;

use App\Entity\AcJournalAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcJournalAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcJournalAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcJournalAnswer[]    findAll()
 * @method AcJournalAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcJournalAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcJournalAnswer::class);
    }

    // /**
    //  * @return AcJournalAnswer[] Returns an array of AcJournalAnswer objects
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
    public function findOneBySomeField($value): ?AcJournalAnswer
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
