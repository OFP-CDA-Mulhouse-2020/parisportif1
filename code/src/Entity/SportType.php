<?php

namespace App\Entity;

use App\Repository\SportTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportTypeRepository::class)
 */
class SportType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2)
     */
    private string $description;

    /**
     * @var Collection<int, Event>
     *
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="sportType", orphanRemoval=true)
     */
    private Collection $events;

    /**
     * @var Collection<int, Competition>
     *
     * @ORM\ManyToMany(targetEntity=Competition::class, mappedBy="sportTypes")
     */
    private Collection $competitions;

    /**
     * @var Collection<int, Sport>
     *
     * @ORM\ManyToMany(targetEntity=Sport::class, mappedBy="sportTypes")
     */
    private Collection $sports;


    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->competitions = new ArrayCollection();
        $this->sports = new ArrayCollection();
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
            $event->setSportType($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getSportType() === $this) {
                $event->setSportType(null);
            }
        }

        return $this;
    }

    /** @return Collection<int, Competition> */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions[] = $competition;
            $competition->addSportType($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competitions->removeElement($competition)) {
            $competition->removeSportType($this);
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
            $sport->addSportType($this);
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        if ($this->sports->removeElement($sport)) {
            $sport->removeSportType($this);
        }

        return $this;
    }
}
