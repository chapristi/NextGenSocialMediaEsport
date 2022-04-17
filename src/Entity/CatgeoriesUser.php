<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\MultiInsertCategoriesUserController;
use App\Repository\CatgeoriesUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CatgeoriesUserRepository::class)]
#[ApiResource(

    collectionOperations: [
        "get" => [
            "security" => 'is_granted("ROLE_USER")',

        ],


        'multiInsert' => [
            "pagination_enabled"  => false,
            "path" => "/catgeories_users/multiInsert",
            "method" => "POST",
            "controller" => MultiInsertCategoriesUserController::class,
            "security" => 'is_granted("ROLE_USER")',

        ]
    ],
    itemOperations: [
        "get" => [
            "security" => 'is_granted("ROLE_USER")',
        ],
        "put" => [
            "security" => 'is_granted("ROLE_ADMIN")',
        ],
        "delete" => [
            "security" => 'is_granted("DELETE_CATEGORIES_USER",object)',
        ],
        "patch" => [
            "security" => 'is_granted("ROLE_ADMIN")',
        ],
    ],
    denormalizationContext: ["groups" => ["write:CatgeoriesUser"]],
    normalizationContext: ["groups" => ["read:CatgeoriesUser"]],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 10,
    //le client peut donc choisir le nombre d'item par page
    paginationMaximumItemsPerPage: 10,
)]
#[ApiFilter(SearchFilter::class, properties: ['category.name' => 'exact'])]
class CatgeoriesUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:CatgeoriesUser"])]

    private $id;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'catgeoriesUsers')]
    #[Groups(["read:CatgeoriesUser","write:CatgeoriesUser"])]
    private $category;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'catgeoriesUsers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:CatgeoriesUser"])]
    private $user;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
