<?php

namespace App\Enum;

enum ModePaiement: string
{
    case ESPECES = 'especes';              // Espèces
    case VIREMENT = 'virement';      // Virement bancaire
    case CHEQUE = 'cheque';          // Chèque
    case CARTE_BANCAIRE = 'carte_bancaire';            // Carte bancaire
    case PRELEVEMENT = 'prelevement';  // Prélèvement automatique
    case PAYPAL = 'paypal';          // PayPal
    case CRYPTOMONNAIE = 'cryptomonnaie';   // Cryptomonnaie (ex: Bitcoin)
    case LIQUIDE = 'liquide';               // Paiement liquide (espèces physiques)

    public function label(): string
    {
        return match ($this) {
            self::ESPECES => 'Espèces',
            self::VIREMENT => 'Virement bancaire',
            self::CHEQUE => 'Chèque',
            self::CARTE_BANCAIRE => 'Carte bancaire',
            self::PRELEVEMENT => 'Prélèvement automatique',
            self::PAYPAL => 'PayPal',
            self::CRYPTOMONNAIE => 'Cryptomonnaie',
            self::LIQUIDE => 'Paiement liquide',
        };
    }
}
