<?php

namespace App\Repository;

use App\Entity\AcJournalQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcJournalQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcJournalQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcJournalQuestion[]    findAll()
 * @method AcJournalQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcJournalQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcJournalQuestion::class);
    }

    public function getWithSearchQueryBuilder(?string $filter_label = null): \Doctrine\ORM\QueryBuilder
    {
        if (isset($filter_label) && strlen(trim($filter_label)) > 0)
        {
            return $this->createQueryBuilder('a')
                ->andWhere('a.label LIKE :filter_label')
                ->setParameter('filter_label', '%' . trim($filter_label) . '%')
                ->orderBy('a.id', 'ASC');
        }
        else
        {
            return $this->createQueryBuilder('a')
                ->orderBy('a.id', 'ASC');
        }
    }

    /**
     * @return AcJournalQuestion[] Returns an array of AcJournalQuestion objects
     */
    public function findByEnabled($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.enabled = :val')
            ->setParameter('val', $value)
            ->orderBy('a.sortOrder', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return AcJournalQuestion[] Returns an array of AcJournalQuestion objects
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
    public function findOneBySomeField($value): ?AcJournalQuestion
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
