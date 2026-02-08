<?php

namespace App\Entity;

use App\Enum\StatutDevis;
use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column]
    private ?float $montantTotal = null;

    #[ORM\Column(enumType: StatutDevis::class)]
    private ?StatutDevis $statut = null;

    /**
     * @var Collection<int, LingeDevis>
     */
    #[ORM\OneToMany(targetEntity: LingeDevis::class, mappedBy: 'devis')]
    private Collection $lingeDevis;

    public function __construct()
    {
        $this->lingeDevis = new ArrayCollection();
    }

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

    public function getStatut(): ?StatutDevis
    {
        return $this->statut;
    }

    public function setStatut(StatutDevis $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, LingeDevis>
     */
    public function getLingeDevis(): Collection
    {
        return $this->lingeDevis;
    }

    public function addLingeDevi(LingeDevis $lingeDevi): static
    {
        if (!$this->lingeDevis->contains($lingeDevi)) {
            $this->lingeDevis->add($lingeDevi);
            $lingeDevi->setDevis($this);
        }

        return $this;
    }

    public function removeLingeDevi(LingeDevis $lingeDevi): static
    {
        if ($this->lingeDevis->removeElement($lingeDevi)) {
            // set the owning side to null (unless already changed)
            if ($lingeDevi->getDevis() === $this) {
                $lingeDevi->setDevis(null);
            }
        }

        return $this;
    }
}
