<?php

namespace App\Entity;

use App\Enum\StatutFacture;
use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column]
    private ?float $montantTotal = null;

    #[ORM\Column(enumType: StatutFacture::class)]
    private ?StatutFacture $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getStatut(): ?StatutFacture
    {
        return $this->statut;
    }

    public function setStatut(StatutFacture $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
