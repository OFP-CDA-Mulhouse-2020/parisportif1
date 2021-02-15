<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CompetitorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetitorRepository::class)
 * @UniqueEntity(
 *     fields = {"id"},
 *     groups = {"newCompetitor"}
 * )
 * @UniqueEntity(
 *     fields = {"name", "countryCode"},
 *     groups = {"newCompetitor", "editCompetitorName", "editCompetitorCountry"}
 * )
 */
class Competitor
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
     *     groups = {"newCompetitor", "editCompetitorCountry"},
     *     normalizer = "trim"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     groups = {"newCompetitor", "editCompetitorCountry"},
     *     normalizer = "trim"
     * )
     * @Assert\Country(
     *     groups = {"newCompetitor", "editCompetitorCountry"}
     * )
     */
    private string $countryCode;


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

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}
