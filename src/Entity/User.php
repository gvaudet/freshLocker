<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]   // Assert Validation email utilisateur unique à placer ici /!\
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(
        message: "Veuillez saisir un email",
    )]
    #[Assert\Length(
        max: 180,
        maxMessage: "L'e-mail doit contenir au maximum {{ limit }} caractères",
    )]
    #[Assert\Email(
        message: "{{ value }} n'est pas un e-mail valide",
        mode: "loose",
    )]
    private ?string $email = null;


    #[ORM\Column]
    private array $roles = [];

    
    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Cart $cart = null;

    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'users')]
    private Collection $address;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Order::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->address = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }


    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        // set the owning side of the relation if necessary
        if ($cart->getUser() !== $this) {
            $cart->setUser($this);
        }

        $this->cart = $cart;

        return $this;
    }


    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address->add($address);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        $this->address->removeElement($address);

        return $this;
    }


    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }


    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;
    
    #[Assert\NotBlank(
        message: "Veuillez saisir un mot de passe",
    )]
    #[Assert\Length(
        min: 8,
        max: 20,
        minMessage: "Le mot de passe doit contenir au minimum {{ limit }} caractères",
        maxMessage: "Le mot de passe doit contenir au maximum {{ limit }} caractères",
    )]
    #[Assert\Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$/')]
    // Regex exigeant 8 à 20 caractères, comportant au moins une Maj, une min, un chiffre, et un caractère spécial
    #[Assert\NotCompromisedPassword]
    // Attention à la communication du message de refus concernant un mot de passe compromis /!\
    private ?string $plainPassword = null;


    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(
        message: "Veuillez saisir un prénom",
    )]
    #[Assert\Length(
        max: 50,
        maxMessage: "Le prénom doit contenir au maximum {{ limit }} caractères",
    )]
    private ?string $firstname = null;


    #[ORM\Column(length: 50)]
    private ?string $lastname = null;
    #[Assert\NotBlank(
        message: "Veuillez saisir un nom",
    )]
    #[Assert\Length(
        max: 50,
        maxMessage: "Le nom doit contenir au maximum {{ limit }} caractères",
    )]


    #[ORM\Column]
    private ?bool $isEnabled = true;

    
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(
        message: "Veuillez saisir un numéro de téléphone",
    )]
    #[Assert\Length(
        min: 10,
        max: 50,
        maxMessage: "Le numéro de téléphone doit contenir au maximum {{ limit }} caractères",
    )]
    private ?string $phoneNumber = null;
    // STRING car sinon le 0 ne sera pas pris en compte


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    // Conversion de l'objet User en string
    public function __toString()
    {
        return $this->getFirstname()." ".$this->getLastname();
    }
}
