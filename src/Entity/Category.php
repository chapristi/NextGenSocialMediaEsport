<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(

)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CatgeoriesTeamsEsport::class)]
    private $teamEsport;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CatgeoriesTeamsEsport::class)]
    private $catgeoriesTeamsEsports;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CatgeoriesUser::class)]
    private $catgeoriesUsers;

    public function __construct()
    {
        $this->teamEsport = new ArrayCollection();
        $this->catgeoriesTeamsEsports = new ArrayCollection();
        $this->catgeoriesUsers = new ArrayCollection();
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

    /**
     * @return Collection|CatgeoriesTeamsEsport[]
     */
    public function getTeamEsport(): Collection
    {
        return $this->teamEsport;
    }

    public function addTeamEsport(CatgeoriesTeamsEsport $teamEsport): self
    {
        if (!$this->teamEsport->contains($teamEsport)) {
            $this->teamEsport[] = $teamEsport;
            $teamEsport->setCategory($this);
        }

        return $this;
    }

    public function removeTeamEsport(CatgeoriesTeamsEsport $teamEsport): self
    {
        if ($this->teamEsport->removeElement($teamEsport)) {
            // set the owning side to null (unless already changed)
            if ($teamEsport->getCategory() === $this) {
                $teamEsport->setCategory(null);
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
            $catgeoriesTeamsEsport->setCategory($this);
        }

        return $this;
    }

    public function removeCatgeoriesTeamsEsport(CatgeoriesTeamsEsport $catgeoriesTeamsEsport): self
    {
        if ($this->catgeoriesTeamsEsports->removeElement($catgeoriesTeamsEsport)) {
            // set the owning side to null (unless already changed)
            if ($catgeoriesTeamsEsport->getCategory() === $this) {
                $catgeoriesTeamsEsport->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CatgeoriesUser[]
     */
    public function getCatgeoriesUsers(): Collection
    {
        return $this->catgeoriesUsers;
    }

    public function addCatgeoriesUser(CatgeoriesUser $catgeoriesUser): self
    {
        if (!$this->catgeoriesUsers->contains($catgeoriesUser)) {
            $this->catgeoriesUsers[] = $catgeoriesUser;
            $catgeoriesUser->setCategory($this);
        }

        return $this;
    }

    public function removeCatgeoriesUser(CatgeoriesUser $catgeoriesUser): self
    {
        if ($this->catgeoriesUsers->removeElement($catgeoriesUser)) {
            // set the owning side to null (unless already changed)
            if ($catgeoriesUser->getCategory() === $this) {
                $catgeoriesUser->setCategory(null);
            }
        }

        return $this;
    }
}
