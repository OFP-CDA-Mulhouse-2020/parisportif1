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
    private int $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Type("string")
     * @Assert\Length(min = 1)
     */
    private string $name;

    /**
     * @var Collection<int, Event>
     *
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="competition")
     */
    private Collection $events;

    /**
     * @var Collection<int, Competition>
     *
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="competitions")
     */
    private Collection $competitions;

    /**
     * @var Collection<int, Sport>
     *
     * @ORM\ManyToMany(targetEntity=Sport::class, inversedBy="competitions")
     */
    private Collection $sports;

    /**
     * @var Collection<int, SportType>
     *
     * @ORM\ManyToMany(targetEntity=SportType::class, inversedBy="competitions")
     */
    private Collection $sportTypes;


    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->competitions = new ArrayCollection();
        $this->sports = new ArrayCollection();
        $this->sportTypes = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /** @return Collection<int, Event> */
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

    /** @return Collection<int, Competition> */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    /** @param Collection<int, Competition> $competitions */
    public function setCompetitions(Collection $competitions): self
    {
        $this->competitions = $competitions;

        return $this;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions[] = $competition;
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competitions->removeElement($competition)) {
            // set the owning side to null (unless already changed)
            if ($competition->getCompetitions() === $this) {
                $competition->setCompetitions(null);
            }
        }

        return $this;
    }

    /** @return Collection<int, Sport> */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        $this->sports->removeElement($sport);

        return $this;
    }

    /** @return Collection<int, SportType> */
    public function getSportTypes(): Collection
    {
        return $this->sportTypes;
    }

    public function addSportType(SportType $sportType): self
    {
        if (!$this->sportTypes->contains($sportType)) {
            $this->sportTypes[] = $sportType;
        }

        return $this;
    }

    public function removeSportType(SportType $sportType): self
    {
        $this->sportTypes->removeElement($sportType);

        return $this;
    }
}
