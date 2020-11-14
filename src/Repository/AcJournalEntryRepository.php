<?php

namespace App\Repository;

use App\Entity\AcJournalEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcJournalEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcJournalEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcJournalEntry[]    findAll()
 * @method AcJournalEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcJournalEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcJournalEntry::class);
    }

    public function getWithDateSearchQueryBuilder(?string $filter_date = null): \Doctrine\ORM\QueryBuilder
    {
        $date_string = substr(trim($filter_date), 0, 10);

        if (isset($date_string) && strlen(trim($date_string)) == 10
            && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date_string))
        {
            return $this->createQueryBuilder('e')
                ->select('e', 'a')
                ->join('e.answers', 'a')
                ->join('e.author', 't')
                ->andWhere('e.createdAt BETWEEN :filter_date_from AND :filter_date_to')
                ->setParameter('filter_date_from', $date_string)
                ->setParameter('filter_date_to', $date_string . ' 23:59:59')
                ->orderBy('e.id', 'DESC');
        }
        else
        {
            return $this->createQueryBuilder('e')
                ->select('e', 'a')
                ->join('e.answers', 'a')
                ->join('e.author', 't')
                ->orderBy('e.id', 'DESC');
        }
    }

    public function getHomePageQueryBuilder(?bool $display_private_posts = false): \Doctrine\ORM\QueryBuilder
    {
        if ($display_private_posts)
        {
            return $this->createQueryBuilder('e')
                ->select('e', 'a')
                ->join('e.answers', 'a')
                ->orderBy('e.id', 'DESC');
        }
        else
        {
            return $this->createQueryBuilder('e')
                ->select('e', 'a')
                ->join('e.answers', 'a')
                ->andWhere('e.isPrivate = 0')
                ->orderBy('e.id', 'DESC');
        }
    }

    public function findJournalEntriesPerMonth(\DateTime $filter_date = null)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT CAST(YEAR(created_at) as varchar) + ' ' + CAST(MONTH(created_at) as varchar) AS created_month, 
            (YEAR(created_at)*12) + MONTH(created_at) AS sort_month,
            COUNT(*) AS entry_count
            FROM ac_journal_entry
            WHERE created_at >= :created_at
            GROUP BY CAST(YEAR(created_at) as varchar) + ' ' + CAST(MONTH(created_at) as varchar),
            (YEAR(created_at)*12) + MONTH(created_at)
            ORDER BY (YEAR(created_at)*12) + MONTH(created_at)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['created_at' => $filter_date->format('Y-m-d')]);

        return $stmt->fetchAllAssociative();
    }

    public function findJournalEntriesFromDate(\DateTime $filter_date = null)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.createdAt >= :filter_date')
            ->setParameter('filter_date', $filter_date->format('Y-m-d'))
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return AcJournalEntry[] Returns an array of AcJournalEntry objects
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
    public function findOneBySomeField($value): ?AcJournalEntry
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
