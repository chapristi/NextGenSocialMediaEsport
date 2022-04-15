<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BasketRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
#[ApiResource()]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Products::class, inversedBy: 'baskets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Products $product;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'baskets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $buyer;

    #[ORM\Column(type: 'integer')]
    private ?int $nombre;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $token;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $status;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    public function __construct(){
        $this->token = Uuid::uuid4();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
}
