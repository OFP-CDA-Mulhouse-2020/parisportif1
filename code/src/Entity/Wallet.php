<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private int $balance;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="wallet", cascade={"persist", "remove"})
     */
    private User $user;

    /**
     * @var Collection<int, BetPayment>
     *
     * @ORM\OneToMany(targetEntity=BetPayment::class, mappedBy="wallet", orphanRemoval=true)
     */
    private Collection $betPayments;

    public function __construct()
    {
        $this->betPayments = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        // set the owning side of the relation if necessary
        if ($user->getWallet() !== $this) {
            $user->setWallet($this);
        }

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
            $this->betPayments[] = $betPayment;
            $betPayment->setWallet($this);
        }

        return $this;
    }

    public function removePayment(BetPayment $betPayment): self
    {
        if ($this->betPayments->removeElement($betPayment)) {
            // set the owning side to null (unless already changed)
            if ($betPayment->getWallet() === $this) {
                $betPayment->setWallet(null);
            }
        }

        return $this;
    }
}
