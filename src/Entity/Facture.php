<?php

namespace App\Entity;

use App\Enum\StatutFacture;
use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, LigneFacture>
     */
    #[ORM\OneToMany(targetEntity: LigneFacture::class, mappedBy: 'facture')]
    private Collection $ligneFactures;

    /**
     * @var Collection<int, NoteFinanciere>
     */
    #[ORM\OneToMany(targetEntity: NoteFinanciere::class, mappedBy: 'facture')]
    private Collection $noteFinancieres;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'facture')]
    private Collection $payments;

    public function __construct()
    {
        $this->ligneFactures = new ArrayCollection();
        $this->noteFinancieres = new ArrayCollection();
        $this->payments = new ArrayCollection();
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

    public function getStatut(): ?StatutFacture
    {
        return $this->statut;
    }

    public function setStatut(StatutFacture $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, LigneFacture>
     */
    public function getLigneFactures(): Collection
    {
        return $this->ligneFactures;
    }

    public function addLigneFacture(LigneFacture $ligneFacture): static
    {
        if (!$this->ligneFactures->contains($ligneFacture)) {
            $this->ligneFactures->add($ligneFacture);
            $ligneFacture->setFacture($this);
        }

        return $this;
    }

    public function removeLigneFacture(LigneFacture $ligneFacture): static
    {
        if ($this->ligneFactures->removeElement($ligneFacture)) {
            // set the owning side to null (unless already changed)
            if ($ligneFacture->getFacture() === $this) {
                $ligneFacture->setFacture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteFinanciere>
     */
    public function getNoteFinancieres(): Collection
    {
        return $this->noteFinancieres;
    }

    public function addNoteFinanciere(NoteFinanciere $noteFinanciere): static
    {
        if (!$this->noteFinancieres->contains($noteFinanciere)) {
            $this->noteFinancieres->add($noteFinanciere);
            $noteFinanciere->setFacture($this);
        }

        return $this;
    }

    public function removeNoteFinanciere(NoteFinanciere $noteFinanciere): static
    {
        if ($this->noteFinancieres->removeElement($noteFinanciere)) {
            // set the owning side to null (unless already changed)
            if ($noteFinanciere->getFacture() === $this) {
                $noteFinanciere->setFacture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setFacture($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getFacture() === $this) {
                $payment->setFacture(null);
            }
        }

        return $this;
    }
}
