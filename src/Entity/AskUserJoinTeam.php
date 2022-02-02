<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AskUserJoinTeamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AskUserJoinTeamRepository::class)]
#[ApiResource()]
class AskUserJoinTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: TeamsEsport::class, inversedBy: 'askUserJoinTeams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TeamsEsport $teams;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'askUserJoinTeams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $UserAsked;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'askUserJoinTeams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isAccepted;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $token;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeams(): ?TeamsEsport
    {
        return $this->teams;
    }

    public function setTeams(?TeamsEsport $teams): self
    {
        $this->teams = $teams;

        return $this;
    }

    public function getUserAsked(): ?User
    {
        return $this->UserAsked;
    }

    public function setUserAsked(?User $UserAsked): self
    {
        $this->UserAsked = $UserAsked;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
