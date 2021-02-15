<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 * @UniqueEntity(
 *     fields = {"id"},
 *     groups = {"newTeam"}
 * )
 * @UniqueEntity(
 *     fields = {"name", "countryCode"},
 *     groups = {"newTeam", "editTeamName", "editTeamCountry"}
 * )
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
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(
     *     groups = {"newTeam", "editTeamName"},
     *     normalizer = "trim"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     groups = {"newTeam", "editTeamCountry"},
     *     normalizer = "trim"
     * )
     * @Assert\Country(
     *     groups = {"newTeam", "editTeamCountry"}
     * )
     */
    private string $countryCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\NotBlank(
     *     groups = {"newTeam", "editTeamDescription"},
     *     normalizer = "trim",
     *     allowNull = true
     * )
     */
    private ?string $description;


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
