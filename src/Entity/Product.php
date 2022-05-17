<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $unique_code;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'integer')]
    private $status;

    #[ORM\OneToMany(mappedBy: 'product_id', targetEntity: CategoryToProduct::class, orphanRemoval: true)]
    private $categoryToProducts;

    #[ORM\OneToMany(mappedBy: 'product_id', targetEntity: ProductToOrder::class, orphanRemoval: true)]
    private $productToOrders;

    public function __construct()
    {
        $this->categoryToProducts = new ArrayCollection();
        $this->productToOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqueCode(): ?string
    {
        return $this->unique_code;
    }

    public function setUniqueCode(string $unique_code): self
    {
        $this->unique_code = $unique_code;

        return $this;
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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
            $categoryToProduct->setProduct($this);
        }

        return $this;
    }

    public function removeCategoryToProduct(CategoryToProduct $categoryToProduct): self
    {
        if ($this->categoryToProducts->removeElement($categoryToProduct)) {
            // set the owning side to null (unless already changed)
            if ($categoryToProduct->getProduct() === $this) {
                $categoryToProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductToOrder>
     */
    public function getProductToOrders(): Collection
    {
        return $this->productToOrders;
    }

    public function addProductToOrder(ProductToOrder $productToOrder): self
    {
        if (!$this->productToOrders->contains($productToOrder)) {
            $this->productToOrders[] = $productToOrder;
            $productToOrder->setProduct($this);
        }

        return $this;
    }

    public function removeProductToOrder(ProductToOrder $productToOrder): self
    {
        if ($this->productToOrders->removeElement($productToOrder)) {
            // set the owning side to null (unless already changed)
            if ($productToOrder->getProduct() === $this) {
                $productToOrder->setProduct(null);
            }
        }

        return $this;
    }
}
