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
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;
use Gedmo\Mapping\Annotation as Gedmo;
#[ORM\Entity(repositoryClass: TeamsEsportRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]

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
    #[Groups(["read:TeamsEsport"])]

    private $id;
    #[Groups(["read:TeamsEsport","write:TeamsEsport"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $name;
    #[Groups(["read:TeamsEsport","write:TeamsEsport"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[Groups(["read:TeamsEsport"])]
    #[ApiProperty(identifier: true)]

    #[ORM\Column(type: 'string', length: 255)]

    /**
     * @Gedmo\Slug(fields={"name"})
     */

    private $slug;
    #[Groups(["read:TeamsEsport"])]
    #[ORM\Column(type: 'datetime')]
    private $createdAt;
    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\ManyToMany(targetEntity: UserJoinTeam::class, mappedBy: 'team')]
    private $userJoinTeams;
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->token = Uuid::uuid4();
        $this->userJoinTeams = new ArrayCollection();
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
}