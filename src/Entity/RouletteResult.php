<?php

namespace App\Entity;

use App\Repository\RouletteResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouletteResultRepository::class)]
class RouletteResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\ManyToOne(inversedBy: 'rouletteResults')]
    private ?Roulette $roulette = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateLast = null;

    #[ORM\OneToMany(mappedBy: 'rouletteResult', targetEntity: BetRoulette::class)]
    private Collection $betRoulettes;

    #[ORM\Column(length: 255)]
    private ?string $sessionId = null;



    public function __construct()
    {
        $this->betRoulettes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getRoulette(): ?Roulette
    {
        return $this->roulette;
    }

    public function setRoulette(?Roulette $roulette): static
    {
        $this->roulette = $roulette;

        return $this;
    }

    public function getDateLast(): ?\DateTimeInterface
    {
        return $this->dateLast;
    }

    public function setDateLast(\DateTimeInterface $dateLast): static
    {
        $this->dateLast = $dateLast;

        return $this;
    }

    /**
     * @return Collection<int, BetRoulette>
     */
    public function getBetRoulettes(): Collection
    {
        return $this->betRoulettes;
    }

    public function addBetRoulette(BetRoulette $betRoulette): static
    {
        if (!$this->betRoulettes->contains($betRoulette)) {
            $this->betRoulettes->add($betRoulette);
            $betRoulette->setRouletteResult($this);
        }

        return $this;
    }

    public function removeBetRoulette(BetRoulette $betRoulette): static
    {
        if ($this->betRoulettes->removeElement($betRoulette)) {
            // set the owning side to null (unless already changed)
            if ($betRoulette->getRouletteResult() === $this) {
                $betRoulette->setRouletteResult(null);
            }
        }

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
