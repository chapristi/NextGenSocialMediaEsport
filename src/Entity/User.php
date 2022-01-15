<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Api\CreateUser;
use App\Controller\CheckMailController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
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
    'verif_mail' => [
        'method' => 'POST',
        'path' => '/users/verif/{token}',
        'controller' => CheckMailController::class,
        'read' => false,
    ],
        "get" => [

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
    #mercure: true,
    normalizationContext: ["groups" => ["read:User"]],
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ApiProperty(identifier: false)]
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



    #[ORM\Column(type: 'text')]
    #[Groups(["read:User"])]

    #[ApiProperty(identifier: true)]

    private ?string $code ;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: VerifMail::class)]
    private $verifMails;

    public function __construct()
    {
        $this->code = Uuid::v4();
        $this->verifMails = new ArrayCollection();
    }
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getVerifMails(): Collection
    {
        return $this->verifMails;
    }

    public function addVerifMail(VerifMail $verifMail): self
    {
        if (!$this->verifMails->contains($verifMail)) {
            $this->verifMails[] = $verifMail;
            $verifMail->setUser($this);
        }

        return $this;
    }

    public function removeVerifMail(VerifMail $verifMail): self
    {
        if ($this->verifMails->removeElement($verifMail)) {
            // set the owning side to null (unless already changed)
            if ($verifMail->getUser() === $this) {
                $verifMail->setUser(null);
            }
        }

        return $this;
    }
}
