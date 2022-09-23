<?php

namespace App\Entity;

use App\Repository\CartLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartLineRepository::class)]
class CartLine
{
    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $cart = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

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
}
