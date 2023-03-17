<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $added_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture4 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $dozen_price = null;

    #[ORM\Column(nullable: true)]
    private ?float $nb_dozen = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_total = null;

    #[ORM\Column(nullable: true)]
    private ?float $public_price = null;

    #[ORM\Column(nullable: true)]
    private ?float $promos_price = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount_rate = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: LigneCommande::class)]
    private Collection $lignecommandes;

   
    public function __construct()
    {
        $this->lignecommandes = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAddedDate(): ?\DateTimeInterface
    {
        return $this->added_date;
    }

    public function setAddedDate(\DateTimeInterface $added_date): self
    {
        $this->added_date = $added_date;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updated_date;
    }

    public function setUpdatedDate(?\DateTimeInterface $updated_date): self
    {
        $this->updated_date = $updated_date;

        return $this;
    }

    public function getPicture1(): ?string
    {
        return $this->picture1;
    }

    public function setPicture1(?string $picture1): self
    {
        $this->picture1 = $picture1;

        return $this;
    }

    public function getPicture2(): ?string
    {
        return $this->picture2;
    }

    public function setPicture2(?string $picture2): self
    {
        $this->picture2 = $picture2;

        return $this;
    }

    public function getPicture3(): ?string
    {
        return $this->picture3;
    }

    public function setPicture3(?string $picture3): self
    {
        $this->picture3 = $picture3;

        return $this;
    }

    public function getPicture4(): ?string
    {
        return $this->picture4;
    }

    public function setPicture4(?string $picture4): self
    {
        $this->picture4 = $picture4;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDozenPrice(): ?float
    {
        return $this->dozen_price;
    }

    public function setDozenPrice(?float $dozen_price): self
    {
        $this->dozen_price = $dozen_price;

        return $this;
    }

    public function getNbDozen(): ?float
    {
        return $this->nb_dozen;
    }

    public function setNbDozen(?float $nb_dozen): self
    {
        $this->nb_dozen = $nb_dozen;

        return $this;
    }

    public function getNbTotal(): ?int
    {
        return $this->nb_total;
    }

    public function setNbTotal(?int $nb_total): self
    {
        $this->nb_total = $nb_total;

        return $this;
    }

    public function getPublicPrice(): ?float
    {
        return $this->public_price;
    }

    public function setPublicPrice(?float $public_price): self
    {
        $this->public_price = $public_price;

        return $this;
    }

    public function getPromosPrice(): ?float
    {
        return $this->promos_price;
    }

    public function setPromosPrice(?float $promos_price): self
    {
        $this->promos_price = $promos_price;

        return $this;
    }

    public function getDiscountRate(): ?float
    {
        return $this->discount_rate;
    }

    public function setDiscountRate(?float $discount_rate): self
    {
        $this->discount_rate = $discount_rate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLignecommandes(): Collection
    {
        return $this->lignecommandes;
    }

    public function addLignecommande(LigneCommande $lignecommande): self
    {
        if (!$this->lignecommandes->contains($lignecommande)) {
            $this->lignecommandes->add($lignecommande);
            $lignecommande->setProduct($this);
        }

        return $this;
    }

    public function removeLignecommande(LigneCommande $lignecommande): self
    {
        if ($this->lignecommandes->removeElement($lignecommande)) {
            // set the owning side to null (unless already changed)
            if ($lignecommande->getProduct() === $this) {
                $lignecommande->setProduct(null);
            }
        }

        return $this;
    }
}
