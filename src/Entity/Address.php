<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $number = null;

    #[ORM\Column(length: 120)]
    private ?string $streetName = null;

    #[ORM\Column(length: 5)]
    private ?string $postCode = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column(length: 50)]
    private ?string $country = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'address')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'address', targetEntity: FreshLocker::class)]
    private Collection $freshLockers;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->freshLockers = new ArrayCollection();
    }

    // public function getFullAddress(){
    //     return $this->streetName.' '.$this->postCode.' '.$this->city;
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeAddress($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, FreshLocker>
     */
    public function getFreshLockers(): Collection
    {
        return $this->freshLockers;
    }

    public function addFreshLocker(FreshLocker $freshLocker): self
    {
        if (!$this->freshLockers->contains($freshLocker)) {
            $this->freshLockers->add($freshLocker);
            $freshLocker->setAddress($this);
        }

        return $this;
    }

    public function removeFreshLocker(FreshLocker $freshLocker): self
    {
        if ($this->freshLockers->removeElement($freshLocker)) {
            // set the owning side to null (unless already changed)
            if ($freshLocker->getAddress() === $this) {
                $freshLocker->setAddress(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNumber().'[br]'. $this->getStreetName().'[br]'. $this->getPostCode().'[br]'. $this->getCity();
    }

}
