<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity("email")
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
     * @var array<int, string>
     *
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * Personal data
     */

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Assert\NotBlank(groups={"registerUser", "updateUser"})
     * @Assert\Email(mode="strict", groups={"registerUser", "updateUser"})
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(groups={"addPasswordToUser", "updatePasswordFor:q:User"})
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"registerUser", "updateUser"})
     * @Assert\Regex(
     *     pattern="/^\p{L}+(?:[' -]\p{L}+)*$/u",
     *     groups={"registerUser", "updateUser"}
     * )
     */
    private string $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"registerUser", "updateUser"})
     * @Assert\Regex(
     *     pattern="/^\p{L}+(?:[' -]\p{L}+)*$/u",
     *     groups={"registerUser", "updateUser"}
     * )
     */
    private string $firstname;

    /**
     * @ORM\Column(type="date_immutable")
     *
     * @Assert\LessThanOrEqual(value="-18 years", groups={"registerUser"})
     */
    private DateTimeInterface $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"registerUser", "updateUser"})
     * @Assert\Country(groups={"registerUser", "updateUser"})
     */
    private string $countryCode;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"registerUser", "updateUser"})
     * @Assert\Timezone(groups={"registerUser", "updateUser"})
     */
    private string $timeZone;

    /**
     * @TODO Add missing attribute :
     *        - Gender
     *        - Address
     *        - City
     *        - PostCode
     *        - PhoneNumber
     */

    /**
     * @ORM\OneToOne(targetEntity=Wallet::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid(groups={"addWalletToUser", "updateWalletPaymentHistory", "changeWalletBalance"})
     */
    private Wallet $wallet;

    /**
     * Dates
     */

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
     * Status
     */

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


    public function __construct()
    {
        $this->active = false;
        $this->suspended = false;
        $this->deleted = false;

        $this->activeSince = null;
        $this->suspendedSince = null;
        $this->deletedSince = null;

        $this->creationDate = new DateTimeImmutable();
    }

    /** @codeCoverageIgnore */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @see UserInterface
     * @codeCoverageIgnore
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<int, string> $roles
     * @codeCoverageIgnore
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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
     * @codeCoverageIgnore
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     * @codeCoverageIgnore
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /** @codeCoverageIgnore */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     * @codeCoverageIgnore
     */
    public function getSalt(): ?string
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     * @codeCoverageIgnore
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

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function setTimeZone(string $timeZone): self
    {
        $this->timeZone = $timeZone;

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

    /**
     * @TODO Correctly test once setters correctly configured
     * @codeCoverageIgnore
     */
    public function getCreationDate(): DateTimeInterface
    {
        return $this->creationDate;
    }

    /**
     * @TODO Remove and only set it once
     * @codeCoverageIgnore
     */
    public function setCreationDate(DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @TODO Correctly test once setters correctly configured
     * @codeCoverageIgnore
     */
    public function getActiveSince(): ?DateTimeInterface
    {
        return $this->activeSince;
    }

    /**
     * @TODO Remove when setActive($bool) has been replaced by activate()
     * @codeCoverageIgnore
     */
    public function setActiveSince(?DateTimeInterface $activeSince): self
    {
        $this->activeSince = $activeSince;

        return $this;
    }

    /**
     * @TODO Correctly test once setters correctly configured
     * @codeCoverageIgnore
     */
    public function getSuspendedSince(): ?DateTimeInterface
    {
        return $this->suspendedSince;
    }

    /**
     * @TODO Remove when setSuspended($bool) has been replaced by suspend()
     * @codeCoverageIgnore
     */
    public function setSuspendedSince(?DateTimeInterface $suspendedSince): self
    {
        $this->suspendedSince = $suspendedSince;

        return $this;
    }

    /**
     * @TODO Correctly test once setters correctly configured
     * @codeCoverageIgnore
     */
    public function getDeletedSince(): ?DateTimeInterface
    {
        return $this->deletedSince;
    }

    /**
     * @TODO Remove when setDeleted($bool) has been replaced by delete()
     * @codeCoverageIgnore
     */
    public function setDeletedSince(?DateTimeInterface $deletedSince): self
    {
        $this->deletedSince = $deletedSince;

        return $this;
    }

    /**
     * @TODO Rename to isActive()
     * @codeCoverageIgnore
     */
    public function getActiveState(): bool
    {
        return $this->active;
    }

    /**
     * @TODO Replace by 2 method activate() & deactivate()
     * @codeCoverageIgnore
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @TODO Rename to isSuspended()
     * @codeCoverageIgnore
     */
    public function getSuspended(): bool
    {
        return $this->suspended;
    }

    /**
     * @TODO Replace by 2 method suspend() & unsuspend()
     * @codeCoverageIgnore
     */
    public function setSuspended(bool $suspended): self
    {
        $this->suspended = $suspended;

        return $this;
    }

    /**
     * @TODO Rename to isDeleted()
     * @codeCoverageIgnore
     */
    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @TODO Replace by delete() and maybe add undelete()?
     * @codeCoverageIgnore
     */
    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
