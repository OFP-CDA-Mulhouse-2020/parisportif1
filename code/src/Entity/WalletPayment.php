<?php

namespace App\Entity;

use App\Repository\WalletPaymentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     *
     * @Assert\NotNull(groups={"newWalletPayment"})
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotNull(groups={"newWalletPayment"})
     *
     * @TODO Specific validate one standardized
     */
    private string $transactionID;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotNull(groups={"newWalletPayment"})
     */
    private int $amount;


    /** @codeCoverageIgnore */
    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
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

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
