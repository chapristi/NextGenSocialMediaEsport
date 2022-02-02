<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\AcceptSomeoneInTeam;
use App\Controller\KickSomeoneInTeam;
use App\Repository\UserJoinTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserJoinTeamRepository::class)]
#[ApiResource(
    collectionOperations: [
    "get" => [

    ],
    "post" => [
        //"security" => 'is_granted("ROLE_ADMIN")',
    ],

],
    itemOperations: [
    'acceptSomeone' => [
        'method' => 'POST',
        'path' => '/user_join_teams/accept/{token}',
        'controller' => AcceptSomeoneInTeam::class,
        'read' => false,
    ],
    'kickSomeone' => [
        'method' => 'POST',
        'path' => '/user_join_teams/kick/{token}',
        'controller' => KickSomeoneInTeam::class,
        'read' => false,
    ],
    "get" => [

    ],
    "put" => [

    ],
    "delete" => [

    ],
    "patch" => [

    ],
],
    denormalizationContext: ["groups" => ["write:UserJointeam"]],
    #mercure: true,
    normalizationContext: ["groups" => ["read:UserJointeam"]],
)]

class UserJoinTeam
{
    //#[ApiProperty(identifier: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:UserJointeam",])]

    private ?int $id;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'userJoinTeams')]
    #[Groups(["read:UserJointeam"])]
    private ArrayCollection $user;

    #[ORM\ManyToMany(targetEntity: TeamsEsport::class, inversedBy: 'userJoinTeams')]
    #[Groups(["read:UserJointeam","write:UserJointeam"])]
    private ArrayCollection $team;

    #[ORM\Column(type: 'json')]
    #[Groups(["read:UserJointeam",])]
    private array $role = [];

    #[ORM\Column(type: 'boolean')]
    #[Groups(["read:UserJointeam"])]
    private bool $isValidated = false;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["read:UserJointeam",])]
    private $createdAt;

    #[Groups(["read:UserJointeam",])]
    #[ORM\Column(type: 'string', length: 255)]
    //#[ApiProperty(identifier: true)]
    private string $token;



    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->team = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->token = Uuid::uuid4();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|TeamsEsport[]
     */
    public function getTeam(): Collection
    {
        return $this->team;
    }

    public function addTeam(TeamsEsport $team): self
    {
        if (!$this->team->contains($team)) {
            $this->team[] = $team;
        }

        return $this;
    }

    public function removeTeam(TeamsEsport $team): self
    {
        $this->team->removeElement($team);

        return $this;
    }

    public function getRole(): ?array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): self
    {
        $this->isValidated = $isValidated;

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
