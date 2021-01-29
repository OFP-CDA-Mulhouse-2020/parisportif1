<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status
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
     * @var Collection<int, CompetitorTeamStatus>
     *
     * @ORM\OneToMany(targetEntity=CompetitorTeamStatus::class, mappedBy="status", orphanRemoval=true)
     */
    private Collection $competitorTeamStatuses;

    public function __construct()
    {
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

    /** @return Collection<int, CompetitorTeamStatus> */
    public function getCompetitorTeamStatuses(): Collection
    {
        return $this->competitorTeamStatuses;
    }

    public function addCompetitorTeamStatus(CompetitorTeamStatus $competitorTeamStatus): self
    {
        if (!$this->competitorTeamStatuses->contains($competitorTeamStatus)) {
            $this->competitorTeamStatuses[] = $competitorTeamStatus;
            $competitorTeamStatus->setStatus($this);
        }

        return $this;
    }

    public function removeCompetitorTeamStatus(CompetitorTeamStatus $competitorTeamStatus): self
    {
        if ($this->competitorTeamStatuses->removeElement($competitorTeamStatus)) {
            // set the owning side to null (unless already changed)
            if ($competitorTeamStatus->getStatus() === $this) {
                $competitorTeamStatus->setStatus(null);
            }
        }

        return $this;
    }
}
