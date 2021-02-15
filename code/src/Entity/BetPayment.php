<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BetPaymentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=BetPaymentRepository::class)
 * @UniqueEntity("id")
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
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\Length(min = 5, groups={"newBetPayment"})
     *
     * @TODO Validate description once standardized
     */
    private string $description;


    /** @codeCoverageIgnore */
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

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

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

    /** @Assert\Callback(groups={"newBetPayment"}) */
    public function validateAmount(ExecutionContextInterface $context): void
    {
        if (isset($this->amount) && $this->amount > -100 && $this->amount < 100) {
            $context
                ->buildViolation("Amount is not valid.")
                ->atPath("amount")
                ->addViolation();
        }
    }
}
