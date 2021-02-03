<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BetPaymentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=BetPaymentRepository::class)
 */
final class BetPayment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $betPaymentDate;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min = 5)
     */
    private string $description;


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

    public function getBetPaymentDate(): DateTimeInterface
    {
        return $this->betPaymentDate;
    }

    public function setBetPaymentDate(DateTimeInterface $betPaymentDate): self
    {
        $this->betPaymentDate = $betPaymentDate;

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

    /** @Assert\Callback */
    public function validateAmount(ExecutionContextInterface $context): void
    {
        if ($this->amount > -100 && $this->amount < 100) {
            $context
                ->buildViolation("Amount is not valid.")
                ->atPath("amount")
                ->addViolation();
        }
    }
}
