<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChatTeamRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ChatTeamRepository::class)]
#[ApiResource]
class ChatTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private $id;
    #[NotNull]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'chatTeams')]
    private $user;
    #[NotNull]
    #[ORM\ManyToOne(targetEntity: TeamsEsport::class, inversedBy: 'chatTeams')]
    private $team;

    #[ORM\Column(type: 'text')]
    private $message;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    public function __construct(){
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTeam(): ?TeamsEsport
    {
        return $this->team;
    }

    public function setTeam(?TeamsEsport $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
