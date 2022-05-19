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

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent_id')]
    private $parent;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private $parent_id;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private $products;

    public function __construct()
    {
        $this->parent_id = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getStatus(): ?string
    {
        if ($this->status)
            return 'Active';

        return 'Draft';
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }
}
