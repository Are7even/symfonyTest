<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $status;

    #[ORM\OneToMany(mappedBy: 'category_id', targetEntity: CategoryToProduct::class, orphanRemoval: true)]
    private $categoryToProducts;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent_id')]
    private $parent;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private $parent_id;

    public function __construct()
    {
        $this->categoryToProducts = new ArrayCollection();
        $this->parent_id = new ArrayCollection();
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, CategoryToProduct>
     */
    public function getCategoryToProducts(): Collection
    {
        return $this->categoryToProducts;
    }

    public function addCategoryToProduct(CategoryToProduct $categoryToProduct): self
    {
        if (!$this->categoryToProducts->contains($categoryToProduct)) {
            $this->categoryToProducts[] = $categoryToProduct;
            $categoryToProduct->setCategoryId($this);
        }

        return $this;
    }

    public function removeCategoryToProduct(CategoryToProduct $categoryToProduct): self
    {
        if ($this->categoryToProducts->removeElement($categoryToProduct)) {
            // set the owning side to null (unless already changed)
            if ($categoryToProduct->getCategoryId() === $this) {
                $categoryToProduct->setCategoryId(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParentId(): Collection
    {
        return $this->parent_id;
    }

    public function addParentId(self $parentId): self
    {
        if (!$this->parent_id->contains($parentId)) {
            $this->parent_id[] = $parentId;
            $parentId->setParent($this);
        }

        return $this;
    }

    public function removeParentId(self $parentId): self
    {
        if ($this->parent_id->removeElement($parentId)) {
            // set the owning side to null (unless already changed)
            if ($parentId->getParent() === $this) {
                $parentId->setParent(null);
            }
        }

        return $this;
    }
}
