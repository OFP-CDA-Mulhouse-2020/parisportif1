<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min = 3)
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $paymentDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 5)
     */
    private $transactionID;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min = 5)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getTransactionID(): ?string
    {
        return $this->transactionID;
    }

    public function setTransactionID(string $transactionID): self
    {
        $this->transactionID = $transactionID;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
