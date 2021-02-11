<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 * @UniqueEntity(
 *     fields = {"id"},
 *     groups = {"newStatus"}
 * )
 * @UniqueEntity(
 *     fields = {"name"},
 *     groups = {"newStatus"}
 * )
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
     *
     * @Assert\NotBlank(
     *     groups = {"newStatus", "editStatusName"},
     *     normalizer = "trim"
     * )
     *
     * @TODO Validate once standardized
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     groups = {"newStatus", "editStatusDescription"},
     *     normalizer = "trim"
     * )
     *
     * @TODO Validate once standardized
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
