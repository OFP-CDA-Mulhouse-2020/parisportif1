<?php

namespace App\Entity;

use App\Repository\EventRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository", repositoryClass=EventRepository::class)
 * @UniqueEntity(
 *     fields={"id"},
 *     groups={"newEvent"}
 * )
 * @UniqueEntity(
 *     fields={"name"},
 *     groups={"newEvent", "editEventName"}
 * )
 */
class Event
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
     *     groups = {"newEvent", "editEventName"},
     *     normalizer = "trim"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $eventDate;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(
     *     groups = {"newEvent", "editEventLocation"},
     *     normalizer = "trim"
     * )
     */
    private string $location;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     groups={"newEvent", "editEventCountry"}
     * )
     * @Assert\Country(
     *     groups={"newEvent", "editEventCountry"}
     * )
     */
    private string $countryCode;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     groups = {"newEvent", "editEventTimeZone"},
     *     normalizer = "trim"
     * )
     *
     * @Assert\Timezone(
     *     groups = {"newEvent", "editEventTimeZone"},
     * )
     */
    private string $timeZone;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(
     *     groups = {"newEvent", "editEventDescription"},
     *     normalizer = "trim"
     * )
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     groups = {"newEvent", "editEventResult"},
     *     normalizer = "trim"
     * )
     */
    private string $result;

    /**
     * @var Collection<int|null, Odds|null>
     *
     * @ORM\ManyToMany(targetEntity=Odds::class)
     * @ORM\JoinTable(
     *     inverseJoinColumns={@ORM\JoinColumn(unique=true)}
     * )
     *
     * Not a ManyToMany! JoinColumn is set to unique for inverseJoinColumns.
     * For more details look at {@link https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/association-mapping.html#one-to-many-unidirectional-with-join-table}
     *
     * @Assert\Valid(
     *     groups = {"newEvent", "editEventOdds", "newOdds"},
     *     traverse = true
     * )
     */
    private Collection $oddsList;


    public function __construct()
    {
        $this->oddsList = new ArrayCollection();
    }

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

    public function getEventDate(): DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    /** @return Collection<int|null, Odds|null> */
    public function getOddsList(): Collection
    {
        return $this->oddsList;
    }

    /** @param Collection<int|null, Odds|null> $oddsList */
    public function setOddsList(Collection $oddsList): self
    {
        $this->oddsList = $oddsList;

        return $this;
    }

    public function addOddsToList(Odds $odds): self
    {
        if (!$this->oddsList->contains($odds)) {
            $this->oddsList->add($odds);
        }

        return $this;
    }

    public function removeOddsFromList(Odds $odds): self
    {
        $this->oddsList->removeElement($odds);

        return $this;
    }
}
