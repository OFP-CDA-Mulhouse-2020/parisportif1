<?php

namespace App\Repository;

use App\Entity\TimeZone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TimeZone|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeZone|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeZone[]    findAll()
 * @method TimeZone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeZoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeZone::class);
    }
}
