<?php

namespace App\Entity;

use App\Repository\OddsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OddsRepository::class)
 */
class Odds
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\Length(min = 2, groups={"newOdds"})
     */
    private string $description;

    /**
     * @ORM\Column(type="float")
     *
     * @Assert\GreaterThan(value=1.0, groups={"newOdds", "updateOdds"})
     */
    private float $oddsValue;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $winning;


    /** @codeCoverageIgnore */
    public function getId(): int
    {
        return $this->id;
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

    public function getOddsValue(): float
    {
        return $this->oddsValue;
    }

    public function setOddsValue(float $oddsValue): self
    {
        $this->oddsValue = $oddsValue;

        return $this;
    }

    /**
     * @TODO Rename as isWinning()
     * @codeCoverageIgnore
     */
    public function getWinning(): ?bool
    {
        return $this->winning;
    }

    /**
     * @TODO Rename as setWinningState
     * @codeCoverageIgnore
     */
    public function setWinning(?bool $winning): self
    {
        $this->winning = $winning;

        return $this;
    }
}
