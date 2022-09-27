<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $unitPrice = null;

    #[ORM\Column(length: 50)]
    private ?string $conversionFactor = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    private Collection $category;

    #[ORM\ManyToMany(targetEntity: Stock::class, inversedBy: 'products')]
    private Collection $stock;

    #[ORM\ManyToMany(targetEntity: Conditioning::class, inversedBy: 'products')]
    private Collection $conditioning;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->stock = new ArrayCollection();
        $this->conditioning = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(string $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getConversionFactor(): ?string
    {
        return $this->conversionFactor;
    }

    public function setConversionFactor(string $conversionFactor): self
    {
        $this->conversionFactor = $conversionFactor;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Stock>
     */
    public function getStock(): Collection
    {
        return $this->stock;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stock->contains($stock)) {
            $this->stock->add($stock);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        $this->stock->removeElement($stock);

        return $this;
    }

    /**
     * @return Collection<int, Conditioning>
     */
    public function getConditioning(): Collection
    {
        return $this->conditioning;
    }

    public function addConditioning(Conditioning $conditioning): self
    {
        if (!$this->conditioning->contains($conditioning)) {
            $this->conditioning->add($conditioning);
        }

        return $this;
    }

    public function removeConditioning(Conditioning $conditioning): self
    {
        $this->conditioning->removeElement($conditioning);

        return $this;
    }
}