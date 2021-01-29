<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
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
     * @Assert\GreaterThan("now - 60 seconds")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     * @Assert\GreaterThan(0)
     */
    private int $total;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\OneToOne(targetEntity=Bet::class, inversedBy="betOrder", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Bet $bet;

    /**
     * @var Collection<int, Payment>
     *
     * @ORM\OneToMany(targetEntity=Payment::class, mappedBy="paymentOrder", orphanRemoval=true)
     */
    private Collection $payments;


    public function __construct()
    {
        $this->payments = new ArrayCollection();
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBet(): Bet
    {
        return $this->bet;
    }

    public function setBet(Bet $bet): self
    {
        $this->bet = $bet;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setPaymentOrder($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getPaymentOrder() === $this) {
                $payment->setPaymentOrder(null);
            }
        }

        return $this;
    }
}
