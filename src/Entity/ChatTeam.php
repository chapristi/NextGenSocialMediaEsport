<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChatTeamRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ChatTeamRepository::class)]


#[ApiResource(
    collectionOperations: [
    "get" => [

    ],
    "post" => [

    ],
],
    itemOperations: [
    "get" => [

    ],
    "put" => [
        "security" => 'is_granted("EDIT_TEAM_MESSAGE",object)',

    ],
    "delete" => [

    ],
    "patch" => [


    ],
],
    denormalizationContext: ["groups" => ["write:ChatTeam"]],

    #mercure: true,
    normalizationContext: ["groups" => ["read:ChatTeam"]],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 10,
    //le client peut donc choisir le nombre d'item par page
    paginationMaximumItemsPerPage: 10,
)]
class ChatTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["admin:Read:ChatTeam"])]

    private int $id;
    #[NotNull]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'chatTeams')]
    #[Groups(["read:ChatTeam","admin:Read:ChatTeam","write:ChatTeam","admin:Update:ChatTeam","admin:Write:ChatTeam"])]


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

    public function __construct(){
        $this->createdAt = new DateTime();
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
}
