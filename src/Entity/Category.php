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
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $products;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parentCategory')]
    private ?self $category = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'category')]
    private Collection $parentCategory;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->parentCategory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?self
    {
        return $this->category;
    }

    public function setCategory(?self $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParentCategory(): Collection
    {
        return $this->parentCategory;
    }

    public function addParentCategory(self $parentCategory): static
    {
        if (!$this->parentCategory->contains($parentCategory)) {
            $this->parentCategory->add($parentCategory);
            $parentCategory->setCategory($this);
        }

        return $this;
    }

    public function removeParentCategory(self $parentCategory): static
    {
        if ($this->parentCategory->removeElement($parentCategory)) {
            // set the owning side to null (unless already changed)
            if ($parentCategory->getCategory() === $this) {
                $parentCategory->setCategory(null);
            }
        }

        return $this;
    }
}
