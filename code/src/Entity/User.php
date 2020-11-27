<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var                       string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userStatus;

    /**
     * @ORM\Column(type="boolean")
     */
    private $UserSuspended;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userDeleted;
    /*
     * @ORM\Column(type="date_immutable")
     */
    private $birthdate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email invalided');
        }
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&_*(),.?":{}|<>])(?!.*\s).{8,16}$/ ', $password)) {
            throw new Exception('Password invalided');
        }
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        if (!preg_match('^[a-zA-ZÀ-ÿ_.-]{2,16}$', $lastname)) {
            throw new Exception('last name invalided');
        }
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        if (!preg_match('^[a-zA-ZÀ-ÿ_.-]{2,16}$', $firstname)) {
            throw new Exception('first name invalided');
        }
        $this->firstname = $firstname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUserStatus(): ?bool
    {
        return $this->userStatus;
    }

    public function setUserStatus(bool $userStatus): self
    {
        $this->userStatus = $userStatus;

        return $this;
    }

    public function getUserSuspended(): ?bool
    {
        return $this->UserSuspended;
    }

    public function setUserSuspended(bool $UserSuspended): self
    {
        $this->UserSuspended = $UserSuspended;

        return $this;
    }

    public function getUserDeleted(): ?bool
    {
        return $this->userDeleted;
    }

    public function setUserDeleted(bool $userDeleted): self
    {
        $this->userDeleted = $userDeleted;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthDate(\DateTimeImmutable $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }
}
