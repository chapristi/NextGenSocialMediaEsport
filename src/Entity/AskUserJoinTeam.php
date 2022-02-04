<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\AcceptToJoinTeamController;
use App\Repository\AskUserJoinTeamRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AskUserJoinTeamRepository::class)]
#[ApiResource(
    collectionOperations: [
    "get" => [

    ],
    "post" => [
        "security" => 'is_granted("POST_ASK_USER_JOIN_TEAM",object)',
        "security_message" => "You can't POST because you have not the necessary rights",
    ],
    'accept' => [
        'method' => 'POST',
        'path' => '/ask_user_join_teams/accept/{token}',
        'controller' => AcceptToJoinTeamController::class,
        'read' => false,
    ],

],
    itemOperations: [
        "get" => [

        ],
        "put" => [
            "security" => 'is_granted("ROLE_ADMIN")',
            "security_message" => "You can't PUT this because you have not the necessary right",
        ],
        "delete" => [
            "security" => 'is_granted("DELETE_ASK_USER_JOIN_TEAM",object)',
            "security_message" => "You can't DELETE this because you have not the necessary right",
        ],
        "patch" => [
            "security" => 'is_granted("ROLE_ADMIN")',
            "security_message" => "You can't  PATCH this because you have not the necessary right",
        ],

    ], denormalizationContext: ["groups" => ["write:AskUserJoinTeam"]],
    #mercure: true,
    normalizationContext: ["groups" => ["read:AskUserJoinTeam"]],

)]
class AskUserJoinTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:AskUserJoinTeam"])]
    #[ApiProperty(identifier: false)]

    private ?int $id;

    #[ORM\ManyToOne(targetEntity: TeamsEsport::class, inversedBy: 'askUserJoinTeams')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:AskUserJoinTeam","write:AskUserJoinTeam"])]
    private ?TeamsEsport $teams;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'askUserJoinTeams')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:AskUserJoinTeam","write:AskUserJoinTeam"])]
    private ?User $UserAsked;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'askUserJoinTeams')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:AskUserJoinTeam"])]
    private ?User $users;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["read:AskUserJoinTeam"])]
    private ?bool $isAccepted = false;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["read:AskUserJoinTeam"])]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["read:AskUserJoinTeam"])]
    #[ApiProperty(identifier: true)]
    private ?string $token;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->token = Uuid::uuid4();
    }

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
