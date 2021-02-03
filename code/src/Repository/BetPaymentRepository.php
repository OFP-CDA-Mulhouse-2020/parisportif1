<?php

namespace App\Repository;

use App\Entity\BetPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BetPayment>
 *
 * @method BetPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetPayment[]    findAll()
 * @method BetPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetPayment::class);
    }
}
