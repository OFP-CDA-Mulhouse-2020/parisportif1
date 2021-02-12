<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 * @UniqueEntity(
 *     fields={"id"},
 *     groups={"newSport"}
 * )
 * @UniqueEntity(
 *     fields={"name"},
 *     groups={"newSport", "editSportName"}
 * )
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
     *
     * @Assert\NotBlank(
     *     groups = {"newSport", "editSportName"},
     *     normalizer = "trim"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     groups = {"newSport", "editSportDescription"},
     *     normalizer = "trim"
     * )
     */
    private string $description;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid(
     *     groups = {"newSport", "editSportSportType", "newSportType"},
     * )
     */
    private SportType $sportType;


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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
}
