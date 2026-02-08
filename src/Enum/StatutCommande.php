<?php

namespace App\Enum;
// Définit les différents statuts possibles pour une commande Version PRO avec labels (UI / Angular / API)
enum StatutCommande: string
{
    case BROUILLON = 'brouillon';        // Commande créée, non validée
    case VALIDEE = 'validee';            // Confirmée par le client
    case EN_PREPARATION = 'en_preparation'; // En cours de préparation
    case EXPEDIEE = 'expediee';          // Livrée au transporteur
    case LIVREE = 'livree';              // Reçue par le client
    case ANNULEE = 'annulee';            // Annulée
  
    public function label(): string  // Méthode pour obtenir le label lisible du statut
    {
        return match ($this) {
            self::BROUILLON => 'Brouillon',
            self::VALIDEE => 'Validée',
            self::EN_PREPARATION => 'En préparation',
            self::EXPEDIEE => 'Expédiée',
            self::LIVREE => 'Livrée',
            self::ANNULEE => 'Annulée',
        };
    }
}
