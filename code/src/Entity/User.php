<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(groups={"create", "read"})
     * @Assert\Email(groups={"create", "read"})
     */
    private string $email;

    /**
     * @var array<int, string>
     *
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"update"})
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"update"})
     */
    private string $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"update"})
     */
    private string $firstname;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeInterface $birthdate;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $suspended;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $deleted;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeInterface $creationDate;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private ?DateTimeInterface $activeSince;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private ?DateTimeInterface $suspendedSince;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private ?DateTimeInterface $deletedSince;

    /**
     * @ORM\OneToOne(targetEntity=Wallet::class, inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Wallet $wallet;

    /**
     * @var Collection<int, Order>
     *
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user", orphanRemoval=true)
     */
    private Collection $orders;

    /**
     * @var Collection<int, Bet>
     *
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="user", orphanRemoval=true)
     */
    private Collection $bets;


    public function __construct()
    {
        $this->active = false;
        $this->suspended = false;
        $this->deleted = false;

        $this->activeSince = null;
        $this->suspendedSince = null;
        $this->deletedSince = null;

        $this->creationDate = new DateTimeImmutable();

        $this->orders = new ArrayCollection();
        $this->bets = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
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
        return $this->email;
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

    /** @param array<int, string> $roles */
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
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthdate(): DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getSuspended(): bool
    {
        return $this->suspended;
    }

    public function setSuspended(bool $suspended): self
    {
        $this->suspended = $suspended;

        return $this;
    }

    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCreationDate(): DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getActiveSince(): ?DateTimeInterface
    {
        return $this->activeSince;
    }

    public function setActiveSince(?DateTimeInterface $activeSince): self
    {
        $this->activeSince = $activeSince;

        return $this;
    }

    public function getSuspendedSince(): ?DateTimeInterface
    {
        return $this->suspendedSince;
    }

    public function setSuspendedSince(?DateTimeInterface $suspendedSince): self
    {
        $this->suspendedSince = $suspendedSince;

        return $this;
    }

    public function getDeletedSince(): ?DateTimeInterface
    {
        return $this->deletedSince;
    }

    public function setDeletedSince(?DateTimeInterface $deletedSince): self
    {
        $this->deletedSince = $deletedSince;

        return $this;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;
        return $this;
    }

    /** @return Collection<int, Order> */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    /** @return Collection<int, Bet> */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setUser($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getUser() === $this) {
                $bet->setUser(null);
            }
        }

        return $this;
    }
}
