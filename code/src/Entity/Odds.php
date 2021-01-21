<?php

namespace App\Entity;

use App\Repository\OddsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="odds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="odd", orphanRemoval=true)
     */
    private $bets;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
    }

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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Collection|Bet[]
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setOdd($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getOdd() === $this) {
                $bet->setOdd(null);
            }
        }

        return $this;
    }
}
