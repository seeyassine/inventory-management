<?php

namespace App\Enum;

enum StatutDevis: string
{
    case BROUILLON = 'brouillon';   // Créé, non envoyé
    case ENVOYE = 'envoye';         // Envoyé au client
    case ACCEPTE = 'accepte';       // Accepté par le client
    case REFUSE = 'refuse';         // Refusé
    case EXPIRE = 'expire';         // Date de validité dépassée
    case Transforme = 'transforme';   // Transformé en commande / facture
    case ANNULE = 'annule';         // Annulé par l'entreprise


    public function label(): string
    {
        return match ($this) {
            self::BROUILLON => 'Brouillon',
            self::ENVOYE => 'Envoyé',
            self::ACCEPTE => 'Accepté',
            self::REFUSE => 'Refusé',
            self::EXPIRE => 'Expiré',
            self::Transforme => 'Transformé',
            self::ANNULE => 'Annulé',
        };
    }
}
