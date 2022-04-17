<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TeamsEsportRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\String\Slugger\SluggerInterface;
use Gedmo\Mapping\Annotation as Gedmo;
#[ORM\Entity(repositoryClass: TeamsEsportRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]

#[ApiResource(
    collectionOperations: [
    "get" => [

    ],
    "post" => [
        "security" => 'is_granted("ROLE_USER")'
    ],
],
    itemOperations: [
    "get" => [

    ],
    "put" => [
        "security" => 'is_granted("EDIT_TEAM",object)',
    ],
    "delete" => [
        "security" => 'is_granted("EDIT_TEAM",object)',
    ],
    "patch" => [
        "security" => 'is_granted("EDIT_TEAM",object)',

    ],
],
    denormalizationContext: ["groups" => ["write:TeamsEsport"]],
    #mercure: true,
    normalizationContext: ["groups" => ["read:TeamsEsport"]],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 10,
    //le client peut donc choisir le nombre d'item par page
    paginationMaximumItemsPerPage: 10,
)]
class TeamsEsport
{
    #[ApiProperty(identifier: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]


    private ?int $id;
    #[Groups(["read:CatgeoriesTeams","read:TeamsEsport","admin:Read:TeamsEsport","write:TeamsEsport"])]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;
    #[Groups(["read:CatgeoriesTeams","read:TeamsEsport","admin:Read:TeamsEsport","write:TeamsEsport","admin:Write:TeamsEsport","admin:Update:TeamsEsport"])]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $description;

    #[Groups(["read:CatgeoriesTeams","read:TeamsEsport","admin:Read:TeamsEsport","admin:Write:TeamsEsport","admin:Update:TeamsEsport"])]
    #[ApiProperty(identifier: true)]

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Gedmo\Slug(fields={"name"})
     */
    private ?string $slug;
    #[Groups(["read:CatgeoriesTeams","read:TeamsEsport","admin:Read:TeamsEsport","admin:Write:TeamsEsport","admin:Update:TeamsEsport"])]
    #[ORM\Column(type: 'datetime')]
    private $createdAt;
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["admin:Read:TeamsEsport","admin:Write:TeamsEsport","admin:Update:TeamsEsport"])]
    private ?string $token;
    #[ORM\ManyToMany(targetEntity: UserJoinTeam::class, mappedBy: 'team')]
    #[Groups(["read:TeamsEsport","admin:Read:TeamsEsport"])]
    private  $userJoinTeams;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: ChatTeam::class)]
    private  $chatTeams;

    #[ORM\OneToMany(mappedBy: 'teams', targetEntity: AskUserJoinTeam::class)]
    private $askUserJoinTeams;

    #[ORM\OneToMany(mappedBy: 'teamEsport', targetEntity: CatgeoriesTeamsEsport::class)]
    private $catgeoriesTeamsEsports;
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->token = Uuid::uuid4();
        $this->userJoinTeams = new ArrayCollection();
        $this->chatTeams = new ArrayCollection();
        $this->askUserJoinTeams = new ArrayCollection();
        $this->catgeoriesTeamsEsports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    /**
     * @return Collection|UserJoinTeam[]
     */
    public function getUserJoinTeams(): Collection
    {
        return $this->userJoinTeams;
    }

    public function addUserJoinTeam(UserJoinTeam $userJoinTeam): self
    {
        if (!$this->userJoinTeams->contains($userJoinTeam)) {
            $this->userJoinTeams[] = $userJoinTeam;
            $userJoinTeam->addTeam($this);
        }

        return $this;
    }

    public function removeUserJoinTeam(UserJoinTeam $userJoinTeam): self
    {
        if ($this->userJoinTeams->removeElement($userJoinTeam)) {
            $userJoinTeam->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection|ChatTeam[]
     */
    public function getChatTeams(): Collection
    {
        return $this->chatTeams;
    }

    public function addChatTeam(ChatTeam $chatTeam): self
    {
        if (!$this->chatTeams->contains($chatTeam)) {
            $this->chatTeams[] = $chatTeam;
            $chatTeam->setTeam($this);
        }

        return $this;
    }

    public function removeChatTeam(ChatTeam $chatTeam): self
    {
        if ($this->chatTeams->removeElement($chatTeam)) {
            // set the owning side to null (unless already changed)
            if ($chatTeam->getTeam() === $this) {
                $chatTeam->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AskUserJoinTeam[]
     */
    public function getAskUserJoinTeams(): Collection
    {
        return $this->askUserJoinTeams;
    }

    public function addAskUserJoinTeam(AskUserJoinTeam $askUserJoinTeam): self
    {
        if (!$this->askUserJoinTeams->contains($askUserJoinTeam)) {
            $this->askUserJoinTeams[] = $askUserJoinTeam;
            $askUserJoinTeam->setTeams($this);
        }

        return $this;
    }

    public function removeAskUserJoinTeam(AskUserJoinTeam $askUserJoinTeam): self
    {
        if ($this->askUserJoinTeams->removeElement($askUserJoinTeam)) {
            // set the owning side to null (unless already changed)
            if ($askUserJoinTeam->getTeams() === $this) {
                $askUserJoinTeam->setTeams(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CatgeoriesTeamsEsport[]
     */
    public function getCatgeoriesTeamsEsports(): Collection
    {
        return $this->catgeoriesTeamsEsports;
    }

    public function addCatgeoriesTeamsEsport(CatgeoriesTeamsEsport $catgeoriesTeamsEsport): self
    {
        if (!$this->catgeoriesTeamsEsports->contains($catgeoriesTeamsEsport)) {
            $this->catgeoriesTeamsEsports[] = $catgeoriesTeamsEsport;
            $catgeoriesTeamsEsport->setTeamEsport($this);
        }

        return $this;
    }

    public function removeCatgeoriesTeamsEsport(CatgeoriesTeamsEsport $catgeoriesTeamsEsport): self
    {
        if ($this->catgeoriesTeamsEsports->removeElement($catgeoriesTeamsEsport)) {
            // set the owning side to null (unless already changed)
            if ($catgeoriesTeamsEsport->getTeamEsport() === $this) {
                $catgeoriesTeamsEsport->setTeamEsport(null);
            }
        }

        return $this;
    }
}