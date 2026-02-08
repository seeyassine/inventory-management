<?php

namespace App\Entity;

use App\Repository\LingeDevisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LingeDevisRepository::class)]
class LingeDevis extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    #[ORM\Column]
    private ?float $tvaTaux = null;

    #[ORM\Column]
    private ?float $remisePourcentage = null;

    #[ORM\ManyToOne(inversedBy: 'lingeDevis')]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'lingeDevis')]
    private ?Devis $devis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getTvaTaux(): ?float
    {
        return $this->tvaTaux;
    }

    public function setTvaTaux(float $tvaTaux): static
    {
        $this->tvaTaux = $tvaTaux;

        return $this;
    }

    public function getRemisePourcentage(): ?float
    {
        return $this->remisePourcentage;
    }

    public function setRemisePourcentage(float $remisePourcentage): static
    {
        $this->remisePourcentage = $remisePourcentage;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): static
    {
        $this->devis = $devis;

        return $this;
    }
}
