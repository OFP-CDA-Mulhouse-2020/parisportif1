<?php

namespace App\Entity;

use App\Repository\CompetitorTeamStatusRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetitorTeamStatusRepository::class)
 * @UniqueEntity(
 *     fields={"id"},
 *     groups={"newCompetitorTeamStatus"}
 * )
 * @UniqueEntity(
 *     fields={"competitor", "team"},
 *     groups={
 *          "newCompetitorTeamStatus",
 *          "editCompetitorTeamStatusCompetitor",
 *          "editCompetitorTeamStatusTeam",
 *     }
 * )
 */
class CompetitorTeamStatus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\ManyToOne(targetEntity=Competitor::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid(
     *     groups={
     *          "editCompetitorTeamStatusCompetitor",
     *          "newCompetitor"
     *      }
     * )
     */
    private Competitor $competitor;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid(
     *     groups={
     *          "editCompetitorTeamStatusTeam",
     *          "newTeam"
     *     }
     * )
     */
    private Team $team;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid(
     *     groups={
     *          "editCompetitorTeamStatusStatus",
     *          "newStatus"
     *     }
     * )
     */
    private Status $status;


    /** @codeCoverageIgnore */
    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCompetitor(): Competitor
    {
        return $this->competitor;
    }

    public function setCompetitor(Competitor $competitor): self
    {
        $this->competitor = $competitor;

        return $this;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }
}
