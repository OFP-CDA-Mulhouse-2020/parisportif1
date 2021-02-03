<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
class Bet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(10)
     */
    private int $amount;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThanOrEqual(1)
     */
    private float $odds;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $resolved;

    /**
     * @ORM\ManyToOne(targetEntity=Odds::class, inversedBy="bets")
     * @ORM\JoinColumn(nullable=false)
     */
    private Odds $odd;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bets")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;


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

    public function getOdds(): float
    {
        return $this->odds;
    }

    public function setOdds(float $odds): self
    {
        $this->odds = $odds;

        return $this;
    }

    public function getResolved(): ?bool
    {
        return $this->resolved;
    }

    public function setResolved(?bool $resolved): self
    {
        $this->resolved = $resolved;

        return $this;
    }

    public function getOdd(): Odds
    {
        return $this->odd;
    }

    public function setOdd(Odds $odd): self
    {
        $this->odd = $odd;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
