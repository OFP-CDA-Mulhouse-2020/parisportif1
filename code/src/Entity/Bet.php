<?php

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
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(10)
     */
    private $amount;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThanOrEqual(1)
     */
    private $odds;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $resolved;

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

    public function getOdds(): ?float
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
}
