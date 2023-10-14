<?php

namespace App\Entity;

use App\Repository\BackgroundRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BackgroundRepository::class)]
class Background
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\Url(message: "Veuillez donner une URL valide")]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 10, max: 255, minMessage:"Le titre doit faire plus de 10 caractères", maxMessage: "Le titre ne doit pas faire plus de 255 caractères")]
    private ?string $caption = null;

    #[ORM\ManyToOne(inversedBy: 'backgrounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $relation = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelation(): ?Product
    {
        return $this->relation;
    }

    public function setRelation(?Product $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): static
    {
        $this->caption = $caption;

        return $this;
    }
}
