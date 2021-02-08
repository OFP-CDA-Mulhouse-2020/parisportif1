<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 * @UniqueEntity("id")
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
     *
     * @Assert\GreaterThanOrEqual(value=0, groups={"changeWalletBalance"})
     */
    private int $balance;

    /**
     * @var Collection<int, WalletPayment>
     *
     * @ORM\ManyToMany(targetEntity=WalletPayment::class)
     * @ORM\JoinTable(
     *     inverseJoinColumns={@ORM\JoinColumn(unique=true, nullable=false)}
     * )
     *
     * Not a ManyToMany! JoinColumn is set to unique for inverseJoinColumns.
     * For more details look at {@link https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/association-mapping.html#one-to-many-unidirectional-with-join-table}
     */
    private Collection $walletPaymentHistory;


    public function __construct()
    {
        $this->walletPaymentHistory = new ArrayCollection();
    }

    /** @codeCoverageIgnore */
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

    /** @return Collection<int, WalletPayment> */
    public function getWalletPaymentHistory(): Collection
    {
        return $this->walletPaymentHistory;
    }

    public function addWalletPaymentHistory(WalletPayment $walletPaymentHistory): self
    {
        if (!$this->walletPaymentHistory->contains($walletPaymentHistory)) {
            $this->walletPaymentHistory->add($walletPaymentHistory);
        }

        return $this;
    }

    public function removeWalletPaymentHistory(WalletPayment $walletPaymentHistory): self
    {
        $this->walletPaymentHistory->removeElement($walletPaymentHistory);

        return $this;
    }

    /** @Assert\Callback(groups={"updatePaymentHistory"}) */
    public function validateWalletPaymentHistory(ExecutionContextInterface $context): void
    {
        $validator = $context->getValidator();

        foreach ($this->walletPaymentHistory as $walletPayment) {
            if ($validator->validate($walletPayment, null, ['newWalletPayment'])->count() > 0) {
                $context->buildViolation("walletPaymentHistory contain a non valid WalletPayment")
                    ->atPath("walletPaymentHistory")
                    ->addViolation();
            }
        }
    }
}
