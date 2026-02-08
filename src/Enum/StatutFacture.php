<?php

namespace App\Enum;

enum StatutFacture: string
{
    case BROUILLON = 'brouillon';              // Facture créée, non validée
    case EMISE = 'emise';                      // Facture émise officiellement Facture reçue (version fournisseur)
    case ENVOYEE = 'envoyee';                  // Facture envoyée au client
    case ECHUE = 'echue';                      // Facture non payée à la date d'échéance
    case PARTIELLEMENT_PAYEE = 'partielle';    // Paiement partiel
    case PAYEE = 'payee';                      // Totalement payée
    case EN_RETARD = 'en_retard';              // Facture en retard de paiement
    case IMPAYEE = 'impayee';                  // Facture impayée
    case ANNULEE = 'annulee';                  // Annulée (rare, cas légal)

    public function label(): string
    {
        return match ($this) {
            self::BROUILLON => 'Brouillon',
            self::EMISE => 'Emise',
            self::ENVOYEE => 'Envoyée',
            self::ECHUE => 'Échue',
            self::PARTIELLEMENT_PAYEE => 'Partiellement payée',
            self::PAYEE => 'Payée',
            self::EN_RETARD => 'En retard',
            self::IMPAYEE => 'Impayée',
            self::ANNULEE => 'Annulée',
        };
    }
}   