<?php

namespace App\Entity;

use App\Repository\RouletteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouletteRepository::class)]
class Roulette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(nullable: true)]
    private ?int $moneyGenerated = null;

    #[ORM\OneToMany(mappedBy: 'roulette', targetEntity: RouletteResult::class)]
    private Collection $rouletteResults;

    public function __construct()
    {
        $this->rouletteResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMoneyGenerated(): ?int
    {
        return $this->moneyGenerated;
    }

    public function setMoneyGenerated(?int $moneyGenerated): static
    {
        $this->moneyGenerated = $moneyGenerated;

        return $this;
    }

    /**
     * @return Collection<int, RouletteResult>
     */
    public function getRouletteResults(): Collection
    {
        return $this->rouletteResults;
    }

    public function addRouletteResult(RouletteResult $rouletteResult): static
    {
        if (!$this->rouletteResults->contains($rouletteResult)) {
            $this->rouletteResults->add($rouletteResult);
            $rouletteResult->setRoulette($this);
        }

        return $this;
    }

    public function removeRouletteResult(RouletteResult $rouletteResult): static
    {
        if ($this->rouletteResults->removeElement($rouletteResult)) {
            // set the owning side to null (unless already changed)
            if ($rouletteResult->getRoulette() === $this) {
                $rouletteResult->setRoulette(null);
            }
        }

        return $this;
    }
}
