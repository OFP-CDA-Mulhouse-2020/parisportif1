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
     *
     * @Assert\GreaterThanOrEqual(value=10, groups={"newBet"})
     */
    private int $amount;

    /**
     * @ORM\Column(type="float")
     *
     * @Assert\GreaterThan(value=1.0, groups={"newBet"})
     */
    private float $oddsWhenPayed;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $resolved;

    /**
     * @ORM\ManyToOne(targetEntity=Odds::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid(groups={"newBet", "newOdds", "updateOdds"})
     */
    private Odds $oddsReference;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid(groups={"newBet", "updateUser"})
     */
    private User $user;


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

    public function getOddsWhenPayed(): float
    {
        return $this->oddsWhenPayed;
    }

    public function setOddsWhenPayed(float $oddsWhenPayed): self
    {
        $this->oddsWhenPayed = $oddsWhenPayed;

        return $this;
    }

    /**
     * @TODO Rename to isResolved()
     * @codeCoverageIgnore
     */
    public function getResolved(): ?bool
    {
        return $this->resolved;
    }

    /**
     * @TODO Replace by resolve() and unresolved()?
     * @codeCoverageIgnore
     */
    public function setResolved(?bool $resolved): self
    {
        $this->resolved = $resolved;

        return $this;
    }

    public function getOddsReference(): Odds
    {
        return $this->oddsReference;
    }

    public function setOddsReference(Odds $oddsReference): self
    {
        $this->oddsReference = $oddsReference;

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
