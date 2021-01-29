<?php

namespace App\Repository;

use App\Entity\Odds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Odds>
 *
 * @method Odds|null find($id, $lockMode = null, $lockVersion = null)
 * @method Odds|null findOneBy(array $criteria, array $orderBy = null)
 * @method Odds[]    findAll()
 * @method Odds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OddsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Odds::class);
    }
}
