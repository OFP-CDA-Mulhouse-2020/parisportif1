<?php

namespace App\Entity;

use InvalidArgumentException;
use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(min = 2)
     */
    private $name;

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
        if (!preg_match('/^[A-Z][A-Za-z]{3,19}$/', $name)) {
            throw new InvalidArgumentException('The name of country is invalided');
        }
        $this->name = $name;

        return $this;
    }
}
