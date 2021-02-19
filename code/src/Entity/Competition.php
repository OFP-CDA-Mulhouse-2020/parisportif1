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
     *
     * @Assert\NotBlank(
     *      groups={"newCompetition", "editCompetitionName"},
     *      normalizer="trim"
     * )
     * @Assert\Length(
     *     min = 1,
     *     groups={"newCompetition", "editCompetitionName"}
     * )
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="competitionsList")
     *
     * @Assert\Valid(
     *     groups={"newCompetition", "changeParentCompetition"}
     * )
     */
    private ?Competition $parentCompetition;

    /**
     * @var Collection<int|null, Competition|null>
     *
     * @ORM\OneToMany(targetEntity=Competition::class, mappedBy="parentCompetition")
     *
     * @Assert\Valid(
     *     groups={"newCompetition", "changeCompetitionsCompetitionsList"},
     *     traverse=true
     * )
     */
    private Collection $competitionsList;

    /**
     * @var Collection<int|null, Event|null>
     *
     * @ORM\OneToMany(targetEntity=Competition::class, mappedBy="parentCompetition")
     *
     * @Assert\Valid(
     *     groups={"newCompetition", "changeCompetitionsEventsList", "newEvent"},
     *     traverse=true
     * )
     */
    private Collection $eventsList;


    public function __construct()
    {
        $this->competitionsList = new ArrayCollection();
        $this->eventsList = new ArrayCollection();
    }

    /** @codeCoverageIgnore */
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

    public function getParentCompetition(): ?self
    {
        return $this->parentCompetition ?? null;
    }

    private function setParentCompetition(?self $parentCompetition): self
    {
        $this->parentCompetition = $parentCompetition;

        return $this;
    }

    /** @return Collection<int|null, Competition|null> */
    public function getCompetitionsList(): Collection
    {
        return $this->competitionsList;
    }

    public function addCompetitionToList(self $competitionToAdd): self
    {
        if (!$this->competitionsList->contains($competitionToAdd)) {
            $this->competitionsList->add($competitionToAdd);
            $competitionToAdd->setParentCompetition($this);
        }

        return $this;
    }

    public function removeCompetitionFromList(self $competitionToRemove): self
    {
        if (
            $this->competitionsList->removeElement($competitionToRemove) &&
            $competitionToRemove->getParentCompetition() === $this
        ) {
            $competitionToRemove->setParentCompetition(null);
        }

        return $this;
    }

    /** @return Collection<int|null, Event|null> */
    public function getEventsList(): Collection
    {
        return $this->eventsList;
    }

    public function addEventToList(Event $eventToAdd): self
    {
        if (!$this->eventsList->contains($eventToAdd)) {
            $this->eventsList->add($eventToAdd);
        }

        return $this;
    }

    public function removeEventFromList(Event $eventToRemove): self
    {
        $this->eventsList->removeElement($eventToRemove);

        return $this;
    }
}
