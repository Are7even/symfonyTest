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

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductToOrder::class)]
    private $productToOrders;

    public function __construct()
    {
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
