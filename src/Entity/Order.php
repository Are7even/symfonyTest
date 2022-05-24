<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $status;

    #[ORM\Column(type: 'integer')]
    private $date;

    #[ORM\Column(type: 'integer')]
    private $total_price;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: ProductToOrder::class)]
     private $productToOrders;

    public function __construct()
    {
        $this->status = 1;
        $this->date = time();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(): self
    {
        $this->date = time();

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->total_price;
    }

    public function setTotalPrice(int $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $productToOrder->setOrder($this);
        }

        return $this;
    }

    public function removeProductToOrder(ProductToOrder $productToOrder): self
    {
        if ($this->productToOrders->removeElement($productToOrder)) {
            // set the owning side to null (unless already changed)
            if ($productToOrder->getOrder() === $this) {
                $productToOrder->setOrder(null);
            }
        }

        return $this;
    }
}
