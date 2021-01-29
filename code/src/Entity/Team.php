<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 1,
     *      max = 255
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $description;

    /**
     * @var Collection<int, Event>
     *
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="teams")
     */
    private Collection $events;

    /**
     * @var Collection<int, Competitor>
     *
     * @ORM\ManyToMany(targetEntity=Competitor::class, mappedBy="teams")
     */
    private Collection $competitors;

    /**
     * @var Collection<int, CompetitorTeamStatus>
     *
     * @ORM\OneToMany(targetEntity=CompetitorTeamStatus::class, mappedBy="team", orphanRemoval=true)
     */
    private Collection $competitorTeamStatuses;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->competitors = new ArrayCollection();
        $this->competitorTeamStatuses = new ArrayCollection();
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
            $event->addTeam($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeTeam($this);
        }

        return $this;
    }

    /** @return Collection<int, Competitor> */
    public function getCompetitors(): Collection
    {
        return $this->competitors;
    }

    public function addCompetitor(Competitor $competitor): self
    {
        if (!$this->competitors->contains($competitor)) {
            $this->competitors[] = $competitor;
            $competitor->addTeam($this);
        }

        return $this;
    }

    public function removeCompetitor(Competitor $competitor): self
    {
        if ($this->competitors->removeElement($competitor)) {
            $competitor->removeTeam($this);
        }

        return $this;
    }

    /** @return Collection<int, CompetitorTeamStatus> */
    public function getCompetitorTeamStatuses(): Collection
    {
        return $this->competitorTeamStatuses;
    }

    public function addCompetitorTeamStatus(CompetitorTeamStatus $competitorTeamStatus): self
    {
        if (!$this->competitorTeamStatuses->contains($competitorTeamStatus)) {
            $this->competitorTeamStatuses[] = $competitorTeamStatus;
            $competitorTeamStatus->setTeam($this);
        }

        return $this;
    }

    public function removeCompetitorTeamStatus(CompetitorTeamStatus $competitorTeamStatus): self
    {
        if ($this->competitorTeamStatuses->removeElement($competitorTeamStatus)) {
            // set the owning side to null (unless already changed)
            if ($competitorTeamStatus->getTeam() === $this) {
                $competitorTeamStatus->setTeam(null);
            }
        }

        return $this;
    }
}
