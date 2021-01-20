<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CompetitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetitorRepository::class)
 */
class Competitor
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
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="competitors")
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="competitors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="competitors")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity=CompetitorTeamStatus::class, mappedBy="competitor", orphanRemoval=true)
     */
    private $competitorTeamStatuses;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->competitorTeamStatuses = new ArrayCollection();
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
            $event->addCompetitor($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeCompetitor($this);
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        $this->teams->removeElement($team);

        return $this;
    }

    /**
     * @return Collection|CompetitorTeamStatus[]
     */
    public function getCompetitorTeamStatuses(): Collection
    {
        return $this->competitorTeamStatuses;
    }

    public function addCompetitorTeamStatus(CompetitorTeamStatus $competitorTeamStatus): self
    {
        if (!$this->competitorTeamStatuses->contains($competitorTeamStatus)) {
            $this->competitorTeamStatuses[] = $competitorTeamStatus;
            $competitorTeamStatus->setCompetitor($this);
        }

        return $this;
    }

    public function removeCompetitorTeamStatus(CompetitorTeamStatus $competitorTeamStatus): self
    {
        if ($this->competitorTeamStatuses->removeElement($competitorTeamStatus)) {
            // set the owning side to null (unless already changed)
            if ($competitorTeamStatus->getCompetitor() === $this) {
                $competitorTeamStatus->setCompetitor(null);
            }
        }

        return $this;
    }
}
