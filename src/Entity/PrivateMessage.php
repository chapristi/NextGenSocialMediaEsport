<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PrivateMessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PrivateMessageRepository::class)]
#[ApiResource(


    collectionOperations: [
    "get" => [
        "security" => 'is_granted("ROLE_USER")',

    ],
    "post" => [
        "security" => 'is_granted("POST_PRIVATE_MESSAGE",object)',
        "security_message" => "You can't POST because you are not friend with him actually",
    ],
],
    itemOperations: [
    "get" => [
        "security" => 'is_granted("ROLE_USER")',

    ],
    "put" => [
        "security" => 'is_granted("EDIT_PRIVATE_MESSAGE",object)',
    ],
    "delete" => [
        "security" => 'is_granted("EDIT_PRIVATE_MESSAGE",object)',
    ],
    "patch" => [
        "security" => 'is_granted("EDIT_PRIVATE_MESSAGE",object)',
    ],

], denormalizationContext: ["groups" => ["write:PrivateMessage"]],
    #mercure: true,
    normalizationContext: ["groups" => ["read:PrivateMessage"]],
)]
class PrivateMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:PrivateMessage","admin:Read:PrivateMessage"])]

    private ?int $id;

    #[ORM\ManyToOne(targetEntity: BFF::class, inversedBy: 'privateMessages')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:PrivateMessage","write:PrivateMessage","admin:Read:PrivateMessage","admin:Update:PrivateMessage","admin:Write:PrivateMessage"])]
    private ?BFF $bff;

    #[ORM\Column(type: 'text')]
    #[Groups(["read:PrivateMessage","write:PrivateMessage","admin:Read:PrivateMessage","admin:Update:PrivateMessage","admin:Write:PrivateMessage"])]

    private ?string $message;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["read:PrivateMessage","admin:Read:PrivateMessage","admin:Update:PrivateMessage","admin:Write:PrivateMessage"])]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'privateMessages')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:PrivateMessage","admin:Read:PrivateMessage","admin:Update:PrivateMessage","admin:Write:PrivateMessage"])]

    private ?User $writer;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->token = Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBff(): ?BFF
    {
        return $this->bff;
    }

    public function setBff(?BFF $bff): self
    {
        $this->bff = $bff;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getWriter(): ?User
    {
        return $this->writer;
    }

    public function setWriter(?User $writer): self
    {
        $this->writer = $writer;

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
