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
    #[Groups(["read:User","admin:Read:User"])]


    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["read:User", "write:User","admin:Read:User"])]
    #[Email(null,"it's not a mail" )]
    private ?string $email;

    #[ORM\Column(type: 'json')]
    #[Groups(["read:User","admin:Read:User"])]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(["write:User","admin:Read:User"])]
    #[Length(min: 5, max: 150, minMessage: "Your password is too short", maxMessage: "your password is too long")]

    private string $password;

    #[ORM\Column(type: 'boolean')]
    //ne pas oublier de rajouter le group admin apres pour pouvoir modifier le champs (:
    #[Groups(["read:User","admin:Read:User","admin:Write:User","admin:Update:User"])]

    private bool $IsVerified = false ;



    #[ORM\Column(type: 'text')]
    #[Groups(["admin:Read:User","admin:Write:User","admin:Update:User"])]

    #[ApiProperty(identifier: true)]

    private ?string $code ;


    #[ORM\OneToMany(mappedBy: 'user', targetEntity: VerifMail::class)]
    private $verifMails;

    // quand j'aurais reglé le prblm avec le token #[Groups(["admin:Read:User"])]
    #[ORM\ManyToMany(targetEntity: UserJoinTeam::class, mappedBy: 'user')]
    #[Groups(["read:User","admin:Read:User"])]
    private $userJoinTeams;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ChatTeam::class)]
    private  $chatTeams;

    #[ORM\OneToMany(mappedBy: 'UserAsked', targetEntity: AskUserJoinTeam::class)]
    private $askUserJoinTeams;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: BFF::class)]
    private $sender;

    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: BFF::class)]
    private $receiver;

    #[ORM\OneToMany(mappedBy: 'writer', targetEntity: PrivateMessage::class)]
    private $privateMessages;



    public function __construct()
    {

        $this->code = Uuid::v4();
        $this->verifMails = new ArrayCollection();
        $this->userJoinTeams = new ArrayCollection();
        $this->chatTeams = new ArrayCollection();
        $this->askUserJoinTeams = new ArrayCollection();
        $this->sender = new ArrayCollection();
        $this->receiver = new ArrayCollection();
        $this->privateMessages = new ArrayCollection();
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
            $userJoinTeam->addUser($this);
        }

        return $this;
    }

    public function removeUserJoinTeam(UserJoinTeam $userJoinTeam): self
    {
        if ($this->userJoinTeams->removeElement($userJoinTeam)) {
            $userJoinTeam->removeUser($this);
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
            $chatTeam->setUser($this);
        }

        return $this;
    }

    public function removeChatTeam(ChatTeam $chatTeam): self
    {
        if ($this->chatTeams->removeElement($chatTeam)) {
            // set the owning side to null (unless already changed)
            if ($chatTeam->getUser() === $this) {
                $chatTeam->setUser(null);
            }
        }

        return $this;
    }

    public function getRefresh(): ?string
    {
        return $this->refresh;
    }

    public function setRefresh(string $refresh): self
    {
        $this->refresh = $refresh;

        return $this;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refresh_token;
    }

    public function setRefreshToken(string $refresh_token): self
    {
        $this->refresh_token = $refresh_token;

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
            $askUserJoinTeam->setUserAsked($this);
        }

        return $this;
    }

    public function removeAskUserJoinTeam(AskUserJoinTeam $askUserJoinTeam): self
    {
        if ($this->askUserJoinTeams->removeElement($askUserJoinTeam)) {
            // set the owning side to null (unless already changed)
            if ($askUserJoinTeam->getUserAsked() === $this) {
                $askUserJoinTeam->setUserAsked(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BFF[]
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(BFF $sender): self
    {
        if (!$this->sender->contains($sender)) {
            $this->sender[] = $sender;
            $sender->setSender($this);
        }

        return $this;
    }

    public function removeSender(BFF $sender): self
    {
        if ($this->sender->removeElement($sender)) {
            // set the owning side to null (unless already changed)
            if ($sender->getSender() === $this) {
                $sender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BFF[]
     */
    public function getReceiver(): Collection
    {
        return $this->receiver;
    }

    public function addReceiver(BFF $receiver): self
    {
        if (!$this->receiver->contains($receiver)) {
            $this->receiver[] = $receiver;
            $receiver->setReceiver($this);
        }

        return $this;
    }

    public function removeReceiver(BFF $receiver): self
    {
        if ($this->receiver->removeElement($receiver)) {
            // set the owning side to null (unless already changed)
            if ($receiver->getReceiver() === $this) {
                $receiver->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PrivateMessage[]
     */
    public function getPrivateMessages(): Collection
    {
        return $this->privateMessages;
    }

    public function addPrivateMessage(PrivateMessage $privateMessage): self
    {
        if (!$this->privateMessages->contains($privateMessage)) {
            $this->privateMessages[] = $privateMessage;
            $privateMessage->setWriter($this);
        }

        return $this;
    }

    public function removePrivateMessage(PrivateMessage $privateMessage): self
    {
        if ($this->privateMessages->removeElement($privateMessage)) {
            // set the owning side to null (unless already changed)
            if ($privateMessage->getWriter() === $this) {
                $privateMessage->setWriter(null);
            }
        }

        return $this;
    }
}
