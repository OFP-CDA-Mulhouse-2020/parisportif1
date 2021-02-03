<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 * @UniqueEntity("id")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotNull
     * @Assert\GreaterThan(0)
     */
    private int $total;

    /**
     * @var Collection<int, Bet>
     *
     * @ORM\ManyToMany(targetEntity=BetPayment::class)
     * @ORM\JoinTable(
     *     inverseJoinColumns={@ORM\JoinColumn(unique=true)}
     * )
     *
     * Not a ManyToMany! JoinColumn is set to unique for inverseJoinColumns.
     * For more details look at {@link https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/association-mapping.html#one-to-many-unidirectional-with-join-table}
     */
    private Collection $betList;

    /**
     * @var Collection<int, BetPayment>
     *
     * @ORM\ManyToMany(targetEntity=BetPayment::class)
     * @ORM\JoinTable(
     *     inverseJoinColumns={@ORM\JoinColumn(unique=true)}
     * )
     *
     * Not a ManyToMany! JoinColumn is set to unique for inverseJoinColumns.
     * For more details look at {@link https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/association-mapping.html#one-to-many-unidirectional-with-join-table}
     */
    private Collection $betPayments;


    public function __construct()
    {
        $this->betList = new ArrayCollection();
        $this->betPayments = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /** @return Collection<int, Bet> */
    public function getBetList(): Collection
    {
        return $this->betList;
    }

    public function addBetToList(Bet $bet): self
    {
        if (!$this->betList->contains($bet)) {
            $this->betList->add($bet);
        }

        return $this;
    }

    public function removeBetFromList(Bet $bet): self
    {
        $this->betList->removeElement($bet);

        return $this;
    }

    /** @return Collection<int, BetPayment> */
    public function getBetPayments(): Collection
    {
        return $this->betPayments;
    }

    public function addPayment(BetPayment $betPayment): self
    {
        if (!$this->betPayments->contains($betPayment)) {
            $this->betPayments->add($betPayment);
        }

        return $this;
    }

    public function removePayment(BetPayment $betPayment): self
    {
       $this->betPayments->removeElement($betPayment);

        return $this;
    }
}
