<?php

namespace App\Entity;

use App\Repository\WalletPaymentRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WalletPaymentRepository::class)
 */
class WalletPayment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $transactionID;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="walletPaymentHistory")
     * @ORM\JoinColumn(nullable=false)
     */
    private Wallet $wallet;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTransactionID(): string
    {
        return $this->transactionID;
    }

    public function setTransactionID(string $transactionID): self
    {
        $this->transactionID = $transactionID;

        return $this;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }
}
