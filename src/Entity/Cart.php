<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $cartDate = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartLine::class)]
    private Collection $quantity;

    #[ORM\OneToOne(inversedBy: 'cart', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->quantity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCartDate(): ?\DateTimeInterface
    {
        return $this->cartDate;
    }

    public function setCartDate(\DateTimeInterface $cartDate): self
    {
        $this->cartDate = $cartDate;

        return $this;
    }

    /**
     * @return Collection<int, CartLine>
     */
    public function getQuantity(): Collection
    {
        return $this->quantity;
    }

    public function addQuantity(CartLine $quantity): self
    {
        if (!$this->quantity->contains($quantity)) {
            $this->quantity->add($quantity);
            $quantity->setCart($this);
        }

        return $this;
    }

    public function removeQuantity(CartLine $quantity): self
    {
        if ($this->quantity->removeElement($quantity)) {
            // set the owning side to null (unless already changed)
            if ($quantity->getCart() === $this) {
                $quantity->setCart(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
