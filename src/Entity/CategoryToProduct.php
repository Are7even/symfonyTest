<?php

namespace App\Entity;

use App\Repository\CategoryToProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryToProductRepository::class)]
class CategoryToProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categoryToProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private $category_id;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'categoryToProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private $product_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category_id;
    }

    public function setCategory(?Category $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product_id;
    }

    public function setProduct(?Product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

}
