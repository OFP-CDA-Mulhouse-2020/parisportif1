<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(groups={"create", "read"})
     * @Assert\Email(groups={"create", "read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"update"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"update"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"update"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $birthdate;


    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $suspended;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $activeSince;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $suspendedSince;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $deletedSince;

    /**
     * @ORM\OneToOne(targetEntity=Wallet::class, inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $wallet;


    public function __construct()
    {
        $this->active = false;
        $this->suspended = false;
        $this->deleted = false;
        $this->creationDate = new \DateTimeImmutable();
        $this->birthdate = new \DateTimeImmutable();
    }

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
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&_*(),.?":{}|<>])(?!.*\s).{8,128}$/', $password)) {
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        if (!preg_match('/^[a-zA-ZÀ-ÿ_.-]{2,16}$/', $lastname)) {
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
        if (!preg_match('/^[a-zA-ZÀ-ÿ_.-]{2,16}$/', $firstname)) {
            throw new Exception('first name invalided');
        }
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeImmutable $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getactive(): ?bool
    {
        return $this->active;
    }

    public function setactive(bool $active): self
    {

        $this->active = $active;

        return $this;
    }

    public function getSuspended(): ?bool
    {
        return $this->suspended;
    }

    public function setSuspended(bool $suspended): self
    {
        $this->suspended = $suspended;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeImmutable $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getActiveSince(): ?\DateTimeImmutable
    {
        return $this->activeSince;
    }

    public function setActiveSince(?\DateTimeImmutable $activeSince): self
    {
        $this->activeSince = $activeSince;

        return $this;
    }

    public function getSuspendedSince(): ?\DateTimeImmutable
    {
        return $this->suspendedSince;
    }

    public function setSuspendedSince(?\DateTimeImmutable $suspendedSince): self
    {
        $this->suspendedSince = $suspendedSince;

        return $this;
    }

    public function getDeletedSince(): ?\DateTimeImmutable
    {
        return $this->deletedSince;
    }

    public function setDeletedSince(?\DateTimeImmutable $deletedSince): self
    {
        $this->deletedSince = $deletedSince;

        return $this;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;
        return $this;
    }
}
