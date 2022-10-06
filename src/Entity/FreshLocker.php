<?php

namespace App\Entity;

use App\Repository\FreshLockerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FreshLockerRepository::class)]
class FreshLocker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $serialNumber = null;

    #[ORM\ManyToOne(inversedBy: 'freshLockers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $address = null;

    #[ORM\OneToMany(mappedBy: 'freshLocker', targetEntity: Locker::class)]
    private Collection $lockers;

    public function __construct()
    {
        $this->lockers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName().'[br]'.$this->getAddress();
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

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Locker>
     */
    public function getLockers(): Collection
    {
        return $this->lockers;
    }

    public function addLocker(Locker $locker): self
    {
        if (!$this->lockers->contains($locker)) {
            $this->lockers->add($locker);
            $locker->setFreshLocker($this);
        }

        return $this;
    }

    public function removeLocker(Locker $locker): self
    {
        if ($this->lockers->removeElement($locker)) {
            // set the owning side to null (unless already changed)
            if ($locker->getFreshLocker() === $this) {
                $locker->setFreshLocker(null);
            }
        }

        return $this;
    }
}
