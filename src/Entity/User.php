<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Api\CreateUser;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [

        ],
        "post" => [

        ],
        'create_user' => [
            "pagination_enabled"  => false,
            "path" => "/users/create",

            "method" => "POST",
            "controller" => CreateUser::class,


        ]
    ],
    itemOperations: [
        "get" => [
            "security" => 'is_granted("ROLE_USER")',
        ],
        "put" => [
            "security" => 'is_granted("EDIT_USER",object)',
        ],
        "delete" => [
            "security" => 'is_granted("EDIT_USER",object)',
        ],
        "patch" => [
            "security" => 'is_granted("EDIT_USER",object)',
        ],
    ],
    denormalizationContext: ["groups" => ["write:User"]],
    normalizationContext: ["groups" => ["read:User"]],
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:User"])]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["read:User", "write:User"])]
    #[Email(null,"it's not a mail" )]
    private ?string $email;

    #[ORM\Column(type: 'json')]
    #[Groups(["read:User"])]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(["write:User"])]
    #[Length(min: 5, max: 150, minMessage: "Your password is too short", maxMessage: "your password is too long")]

    private string $password;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["read:User"])]

    private bool $IsVerified = false;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIsVerified(): ?bool
    {
        return $this->IsVerified;
    }

    public function setIsVerified(bool $IsVerified): self
    {
        $this->IsVerified = $IsVerified;

        return $this;
    }
}
