<?php

namespace App\Repository;

use App\Entity\WalletPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WalletPayment>
 *
 * @method WalletPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method WalletPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method WalletPayment[]    findAll()
 * @method WalletPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WalletPayment::class);
    }
}
