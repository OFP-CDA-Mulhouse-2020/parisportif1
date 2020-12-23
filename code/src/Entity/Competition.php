<?php

namespace App\Entity;

use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetitionRepository::class)
 */
class Competition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Type("string")
     * @Assert\Length(min = 1)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="competition")
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="competitions")
     */
    private $competitions;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->competitions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setCompetition($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCompetition() === $this) {
                $event->setCompetition(null);
            }
        }

        return $this;
    }

    public function getCompetitions(): ?self
    {
        return $this->competitions;
    }

    public function setCompetitions(?self $competitions): self
    {
        $this->competitions = $competitions;

        return $this;
    }

    public function addCompetition(self $competition): self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions[] = $competition;
            $competition->setCompetitions($this);
        }

        return $this;
    }

    public function removeCompetition(self $competition): self
    {
        if ($this->competitions->removeElement($competition)) {
            // set the owning side to null (unless already changed)
            if ($competition->getCompetitions() === $this) {
                $competition->setCompetitions(null);
            }
        }

        return $this;
    }
}
