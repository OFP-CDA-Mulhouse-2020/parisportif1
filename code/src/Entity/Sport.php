<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
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
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="sport", orphanRemoval=true)
     */
    private Collection $events;

    /**
     * @var Collection<int, Competition>
     *
     * @ORM\ManyToMany(targetEntity=Competition::class, mappedBy="sports")
     */
    private Collection $competitions;

    /**
     * @var Collection<int, SportType>
     *
     * @ORM\ManyToMany(targetEntity=SportType::class, inversedBy="sports")
     */
    private Collection $sportTypes;


    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->competitions = new ArrayCollection();
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
            $event->setSport($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getSport() === $this) {
                $event->setSport(null);
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
            $competition->addSport($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competitions->removeElement($competition)) {
            $competition->removeSport($this);
        }

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
