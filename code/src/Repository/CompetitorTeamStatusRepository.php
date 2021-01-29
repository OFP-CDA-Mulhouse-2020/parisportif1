<?php

namespace App\Repository;

use App\Entity\CompetitorTeamStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompetitorTeamStatus>
 *
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
}
