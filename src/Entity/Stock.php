<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $externalLotNumber = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $receptionDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $expirationDate = null;

    #[ORM\Column(length: 30)]
    private ?string $storageCondition = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'stock')]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalLotNumber(): ?string
    {
        return $this->externalLotNumber;
    }

    public function setExternalLotNumber(?string $externalLotNumber): self
    {
        $this->externalLotNumber = $externalLotNumber;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getReceptionDate(): ?\DateTimeInterface
    {
        return $this->receptionDate;
    }

    public function setReceptionDate(\DateTimeInterface $receptionDate): self
    {
        $this->receptionDate = $receptionDate;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getStorageCondition(): ?string
    {
        return $this->storageCondition;
    }

    public function setStorageCondition(string $storageCondition): self
    {
        $this->storageCondition = $storageCondition;

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
            $product->addStock($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeStock($this);
        }

        return $this;
    }
}
