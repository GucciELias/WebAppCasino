<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $subject = null;

    #[ORM\Column(length: 255)]
    private ?string $Object = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $TicketDate = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->Object;
    }

    public function setObject(string $Object): static
    {
        $this->Object = $Object;

        return $this;
    }

    public function getTicketDate(): ?\DateTimeInterface
    {
        return $this->TicketDate;
    }

    public function setTicketDate(\DateTimeInterface $TicketDate): static
    {
        $this->TicketDate = $TicketDate;

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
