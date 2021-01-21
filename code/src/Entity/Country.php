<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="country")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="country")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=TimeZone::class, inversedBy="countries")
     */
    private $timeZones;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->timeZones = new ArrayCollection();
    }

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

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setCountry($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCountry() === $this) {
                $event->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCountry($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCountry() === $this) {
                $user->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TimeZone[]
     */
    public function getTimeZones(): Collection
    {
        return $this->timeZones;
    }

    public function addTimeZone(TimeZone $timeZone): self
    {
        if (!$this->timeZones->contains($timeZone)) {
            $this->timeZones[] = $timeZone;
        }

        return $this;
    }

    public function removeTimeZone(TimeZone $timeZone): self
    {
        $this->timeZones->removeElement($timeZone);

        return $this;
    }
}
