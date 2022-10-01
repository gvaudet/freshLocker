<?php

namespace App\Entity;

use App\Repository\ConditioningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConditioningRepository::class)]
class Conditioning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'conditioning')]
    private Collection $products;

    #[ORM\Column(length: 50)]
    private ?string $label = null;

    #[ORM\Column]
    private ?float $conversionFactor = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getLabel();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getConversionFactor(): ?float
    {
        return $this->conversionFactor;
    }

    public function setConversionFactor(float $conversionFactor): self
    {
        $this->conversionFactor = $conversionFactor;

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
            $this->products->add($product);
            $product->addConditioning($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeConditioning($this);
        }

        return $this;
    }
}
