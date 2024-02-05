<?php

namespace App\Entity;

use App\Repository\BetRouletteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BetRouletteRepository::class)]
class BetRoulette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $betType = null;

    #[ORM\Column(nullable: true)]
    private ?int $betNumber = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $montantGagne = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $betDate = null;

    #[ORM\ManyToOne(inversedBy: 'betRoulettes')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'betRoulettes')]
    private ?RouletteResult $rouletteResult = null;

    #[ORM\Column(length: 255)]
    private ?string $sessionId = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getBetType(): ?string
    {
        return $this->betType;
    }

    public function setBetType(?string $betType): static
    {
        $this->betType = $betType;

        return $this;
    }

    public function getBetNumber(): ?int
    {
        return $this->betNumber;
    }

    public function setBetNumber(?int $betNumber): static
    {
        $this->betNumber = $betNumber;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getMontantGagne(): ?int
    {
        return $this->montantGagne;
    }

    public function setMontantGagne(?int $montantGagne): static
    {
        $this->montantGagne = $montantGagne;

        return $this;
    }

    public function getBetDate(): ?\DateTimeInterface
    {
        return $this->betDate;
    }

    public function setBetDate(\DateTimeInterface $betDate): static
    {
        $this->betDate = $betDate;

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

    public function getRouletteResult(): ?RouletteResult
    {
        return $this->rouletteResult;
    }

    public function setRouletteResult(?RouletteResult $rouletteResult): static
    {
        $this->rouletteResult = $rouletteResult;

        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): static
    {
        $this->sessionId = $sessionId;

        return $this;
    }



}
