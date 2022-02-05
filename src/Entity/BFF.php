<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\AcceptFriendRequestController;
use App\Repository\BFFRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BFFRepository::class)]
#[ApiResource(
    collectionOperations: [
    "get" => [
//mettre un obligation de se connecter
    ],
    "post" => [
        "security" => 'is_granted("ROLE_USER")',
    ],
    'kickSomeone' => [
        'method' => 'POST',
        'path' => '/bff/accept/{token}',
        'controller' => AcceptFriendRequestController::class,
        'read' => false,
    ],

],
    itemOperations: [
    "get" => [
//mettre un obligation de se connecter

    ],

    "put" => [
        "security" => 'is_granted("ROLE_ADMIN")',
    ],
    "delete" => [
        "security" => 'is_granted("DELETE_BFF","object")',

    ],
    "patch" => [
        "security" => 'is_granted("ROLE_ADMIN")',
    ],

], denormalizationContext: ["groups" => ["write:BFF"]],
    #mercure: true,
    normalizationContext: ["groups" => ["read:BFF"]],
)]
class BFF
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[ApiProperty(identifier: false)]
    #[Groups(["read:BFF","admin:Read:BFF"])]


    private ?int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sender')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:BFF","admin:Read:BFF","admin:Update:BFF","admin:Write:BFF"])]
    private ?User $sender;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'receiver')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:BFF","write:BFF","admin:Read:BFF","admin:Update:BFF","admin:Write:BFF"])]
    private ?User $receiver;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["read:BFF","admin:Read:BFF","admin:Update:BFF","admin:Write:BFF"])]

    private ?bool $isAccepted = false;

    #[ORM\Column(type: 'string', length: 255)]
    #[ApiProperty(identifier: true)]
    #[Groups(["read:BFF","admin:Read:BFF","admin:Update:BFF","admin:Write:BFF"])]
    private ?string $token;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["read:BFF","admin:Read:BFF","admin:Update:BFF","admin:Write:BFF"])]
    private $createdAt;
    #[ORM\OneToMany(mappedBy: 'bff', targetEntity: PrivateMessage::class)]
    private $privateMessages;
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->token = Uuid::uuid4();
        $this->privateMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
            $privateMessage->setBff($this);
        }

        return $this;
    }

    public function removePrivateMessage(PrivateMessage $privateMessage): self
    {
        if ($this->privateMessages->removeElement($privateMessage)) {
            // set the owning side to null (unless already changed)
            if ($privateMessage->getBff() === $this) {
                $privateMessage->setBff(null);
            }
        }

        return $this;
    }
}
