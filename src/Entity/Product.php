<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields:['name'], message:"Un autre produit possède déjà ce nom, merci de le modifier")]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 10, max: 255, minMessage:"Le nom doit faire plus de 10 caractères", maxMessage: "Le nom ne doit pas faire plus de 255 caractères")]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(min: 10, max: 255, minMessage:"La description doit faire plus de 10 caractères", maxMessage: "La description ne doit pas faire plus de 255 caractères")]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 10, max: 50, minMessage:"Le type doit faire plus de 10 caractères", maxMessage: "Le type ne doit pas faire plus de 50 caractères")]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 10, max: 255, minMessage:"La marque doit faire plus de 10 caractères", maxMessage: "La marque ne doit pas faire plus de 255 caractères")]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    #[Assert\Url(message: "Il faut une URL valide")]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'relation', targetEntity: Background::class, orphanRemoval: true)]
    #[Valid()]
    private Collection $backgrounds;

    public function __construct()
    {
        $this->backgrounds = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Background>
     */
    public function getBackgrounds(): Collection
    {
        return $this->backgrounds;
    }

    public function addBackground(Background $background): static
    {
        if (!$this->backgrounds->contains($background)) {
            $this->backgrounds->add($background);
            $background->setRelation($this);
        }

        return $this;
    }

    public function removeBackground(Background $background): static
    {
        if ($this->backgrounds->removeElement($background)) {
            // set the owning side to null (unless already changed)
            if ($background->getRelation() === $this) {
                $background->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * Permet d'initaliser le slug automatiquement si on ne le donne pas
     *
     * @return void
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug(): void 
    {
        if(empty($this->slug))
        {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->name);
        }
    }
}
