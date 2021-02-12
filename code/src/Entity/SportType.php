<?php

namespace App\Entity;

use App\Repository\SportTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportTypeRepository::class)
 * @UniqueEntity(
 *     fields={"id"},
 *     groups={"newSportType"}
 * )
 * @UniqueEntity(
 *     fields={"name"},
 *     groups={"newSportType", "editSportTypeName"}
 * )
 * @UniqueEntity(
 *     fields={"description"},
 *     groups={"newSportType", "editSportTypeDescription"}
 * )
 */
class SportType
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
     *     groups = {"newSportType", "editSportTypeName"},
     *     normalizer = "trim"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     groups = {"newSportType", "editSportTypeDescription"},
     *     normalizer = "trim"
     * )
     */
    private string $description;


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
}
