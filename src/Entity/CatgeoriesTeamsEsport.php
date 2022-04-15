<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\MultiInsertController;
use App\Repository\CatgeoriesTeamsEsportRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CatgeoriesTeamsEsportRepository::class)]

#[ApiResource(

    collectionOperations: [
        "get" => [

        ],

        'multiInsert' => [
            "pagination_enabled"  => false,
            "path" => "/catgeories_teams_esports/multiInsert",
            "method" => "POST",
            "controller" => MultiInsertController::class,
        ]
    ],
    itemOperations: [
        "get" => [

        ],
        "put" => [
            "security" => 'is_granted("ROLE_ADMIN")',
        ],
        "delete" => [
            "security" => 'is_granted("ROLE_ADMIN")',
        ],
        "patch" => [
            "security" => 'is_granted("ROLE_ADMIN")',
        ],
    ],
    denormalizationContext: ["groups" => ["write:CatgeoriesTeams"]],
    #mercure: true,
    normalizationContext: ["groups" => ["read:CatgeoriesTeams"]],
)]
#[ApiFilter(SearchFilter::class, properties: ['category.name' => 'exact'])]




class CatgeoriesTeamsEsport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:CatgeoriesTeams"])]

    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'catgeoriesTeamsEsports')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["write:CatgeoriesTeams","read:CatgeoriesTeams"])]

    private $category;

    #[ORM\ManyToOne(targetEntity: TeamsEsport::class, inversedBy: 'catgeoriesTeamsEsports')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["write:CatgeoriesTeams","read:CatgeoriesTeams"])]

    private $teamEsport;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTeamEsport(): ?TeamsEsport
    {
        return $this->teamEsport;
    }

    public function setTeamEsport(?TeamsEsport $teamEsport): self
    {
        $this->teamEsport = $teamEsport;

        return $this;
    }
}
