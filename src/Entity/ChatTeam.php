<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ChatTeamRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ChatTeamRepository::class)]


#[ApiResource(
    collectionOperations: [
    "get" => [
        "security" => 'is_granted("ROLE_USER")',

    ],
    "post" => [
        "security_post_denormalize" => 'is_granted("POST_TEAM_MESSAGE",object)',



    ],
],
    itemOperations: [
    "get" => [
        "security" => 'is_granted("ROLE_USER")',

    ],
    "put" => [
        "security" => 'is_granted("EDIT_TEAM_MESSAGE",object)',
        "security_message" => "You can't PUT because you have not the necessary rights",

    ],
    "delete" => [
        "security" => 'is_granted("DELETE_TEAM_MESSAGE",object)',
        "security_message" => "You can't DELETE because you have not the necessary rights",

    ],
    "patch" => [
        "security" => 'is_granted("EDIT_TEAM_MESSAGE",object)',
        "security_message" => "You can't PATCH because you have not the necessary rights",



    ],
],

    denormalizationContext: ["groups" => ["write:ChatTeam"]],
    normalizationContext: ["groups" => ["read:ChatTeam"]],
    paginationClientItemsPerPage: true,
    //le client peut donc choisir le nombre d'item par page
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 10
)]

class ChatTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:ChatTeam","admin:Read:ChatTeam"])]

    private ?int $id;
    #[NotNull]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'chatTeams')]
    #[Groups(["read:ChatTeam","admin:Read:ChatTeam","admin:Update:ChatTeam","admin:Write:ChatTeam"])]


    private ?User $user;
    #[NotNull]
    #[ORM\ManyToOne(targetEntity: TeamsEsport::class, inversedBy: 'chatTeams')]
    #[Groups(["read:ChatTeam","admin:Read:ChatTeam","write:ChatTeam","admin:Update:ChatTeam","admin:Write:ChatTeam"])]

    private ?TeamsEsport $team;

    #[ORM\Column(type: 'text')]
    #[Groups(["read:ChatTeam","admin:Read:ChatTeam","write:ChatTeam","admin:Update:ChatTeam","admin:Write:ChatTeam"])]
    private ?string $message;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["read:ChatTeam","admin:Read:ChatTeam","admin:Update:ChatTeam","admin:Write:ChatTeam"])]
    private  $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    public function __construct(){
        $this->createdAt = new DateTime();
        $this->token = Uuid::uuid4();
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

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
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
