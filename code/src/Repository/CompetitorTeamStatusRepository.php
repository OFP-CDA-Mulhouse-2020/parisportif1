<?php

namespace App\Repository;

use App\Entity\CompetitorTeamStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompetitorTeamStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitorTeamStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitorTeamStatus[]    findAll()
 * @method CompetitorTeamStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitorTeamStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetitorTeamStatus::class);
    }

    // /**
    //  * @return CompetitorTeamStatus[] Returns an array of CompetitorTeamStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompetitorTeamStatus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
