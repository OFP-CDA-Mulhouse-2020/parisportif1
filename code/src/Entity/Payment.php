<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PaymentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
final class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min = 3)
     */
    private int $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $paymentDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 5)
     */
    private string $transactionID;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min = 5)
     */
    private string $description;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private Wallet $wallet;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private Order $paymentOrder;


    public function getId(): int
    {
        return $this->id;
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

    public function getPaymentDate(): DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getPaymentOrder(): Order
    {
        return $this->paymentOrder;
    }

    public function setPaymentOrder(Order $paymentOrder): self
    {
        $this->paymentOrder = $paymentOrder;

        return $this;
    }
}
