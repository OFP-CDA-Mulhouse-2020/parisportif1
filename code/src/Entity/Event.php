<?php

namespace App\Entity;

use App\Repository\EventRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $eventDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2)
     */
    private string $location;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2)
     */
    private string $illustration;

    /**
     * @ORM\Column(type="text")
     */
    private string $result;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private Sport $sport;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="events")
     */
    private Competition $competition;

    /**
     * @var Collection<int, Competitor>
     *
     * @ORM\ManyToMany(targetEntity=Competitor::class, inversedBy="events")
     */
    private Collection $competitors;

    /**
     * @ORM\ManyToOne(targetEntity=SportType::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private SportType $sportType;

    /**
     * @var Collection<int, Team>
     *
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="events")
     */
    private Collection $teams;

    /**
     * @var Collection<int, Odds>
     *
     * @ORM\OneToMany(targetEntity=Odds::class, mappedBy="event")
     */
    private Collection $odds;


    public function __construct()
    {
        $this->competitors = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->odds = new ArrayCollection();
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

    public function getEventDate(): DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getIllustration(): string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getSport(): Sport
    {
        return $this->sport;
    }

    public function setSport(Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getCompetition(): Competition
    {
        return $this->competition;
    }

    public function setCompetition(Competition $competition): self
    {
        $this->competition = $competition;

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
        }

        return $this;
    }

    public function removeCompetitor(Competitor $competitor): self
    {
        $this->competitors->removeElement($competitor);

        return $this;
    }

    public function getSportType(): SportType
    {
        return $this->sportType;
    }

    public function setSportType(SportType $sportType): self
    {
        $this->sportType = $sportType;

        return $this;
    }

    /** @return Collection<int, Team> */
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

    /** @return Collection<int, Odds> */
    public function getOdds(): Collection
    {
        return $this->odds;
    }

    public function addOdd(Odds $odd): self
    {
        if (!$this->odds->contains($odd)) {
            $this->odds[] = $odd;
            $odd->setEvent($this);
        }

        return $this;
    }

    public function removeOdd(Odds $odd): self
    {
        if ($this->odds->removeElement($odd)) {
            // set the owning side to null (unless already changed)
            if ($odd->getEvent() === $this) {
                $odd->setEvent(null);
            }
        }

        return $this;
    }
}
