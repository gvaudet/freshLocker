<?php

namespace App\Entity;

use App\Repository\LockerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LockerRepository::class)]
class Locker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lockers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FreshLocker $freshLocker = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFreshLocker(): ?FreshLocker
    {
        return $this->freshLocker;
    }

    public function setFreshLocker(?FreshLocker $freshLocker): self
    {
        $this->freshLocker = $freshLocker;

        return $this;
    }
}
