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
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min = 2)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThanOrEqual(1)
     */
    private $value;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $winning;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {

        $this->value = $value;

        return $this;
    }

    public function getWinning(): ?bool
    {
        return $this->winning;
    }

    public function setWinning(?bool $winning): self
    {
        $this->winning = $winning;

        return $this;
    }
}
