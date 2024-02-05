<?php

namespace App\Entity;

use App\Repository\PortefeuilleUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortefeuilleUserRepository::class)]
class PortefeuilleUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $solde = null;

    #[ORM\Column(length: 255)]
    private ?array $transaction = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): static
    {
        $this->solde = $solde;

        return $this;
    }

    public function getTransaction(): array
    {
        return $this->transaction;
    }

    public function setTransaction(array $transaction): static
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $userId): static
    {
        $this->user = $userId;

        return $this;
    }
}
