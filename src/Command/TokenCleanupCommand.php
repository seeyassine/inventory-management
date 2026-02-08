<?php

namespace App\Command;

use App\Entity\RefreshToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:token:cleanup',
    description: 'Nettoie les tokens expirés avec option dry-run'
)]
class TokenCleanupCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Simulation seulement')
            ->addOption('before-date', null, InputOption::VALUE_OPTIONAL, 'Date limite (format: Y-m-d)')
            ->addOption('show-details', 'd', InputOption::VALUE_NONE, 'Afficher les détails des tokens'); // Changé de --verbose à --show-details
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $dryRun = $input->getOption('dry-run');
        $showDetails = $input->getOption('show-details'); // Changé ici aussi
        
        $io->title('Nettoyage des Refresh Tokens');
        
        // Déterminer la date limite
        $beforeDate = $input->getOption('before-date');
        if ($beforeDate) {
            try {
                $date = new \DateTime($beforeDate);
            } catch (\Exception $e) {
                $io->error('Format de date invalide. Utilisez Y-m-d (ex: 2024-01-15)');
                return Command::FAILURE;
            }
        } else {
            $date = new \DateTime(); // Maintenant
        }
        
        $io->note(sprintf(
            'Suppression des tokens expirés avant: %s',
            $date->format('Y-m-d H:i:s')
        ));
        
        // 1. Compter les tokens à supprimer
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('COUNT(token.id)')
            ->from(RefreshToken::class, 'token')
            ->where('token.valid < :date')
            ->setParameter('date', $date);
        
        $count = (int) $queryBuilder->getQuery()->getSingleScalarResult();
        
        if ($count === 0) {
            $io->success('Aucun token à nettoyer.');
            return Command::SUCCESS;
        }
        
        $io->warning(sprintf('%d tokens vont être supprimés.', $count));
        
        // 2. Afficher les détails si show-details
        if ($showDetails) {
            $detailsQuery = $this->entityManager->createQueryBuilder();
            $detailsQuery
                ->select('token.username', 'token.refreshToken', 'token.valid')
                ->from(RefreshToken::class, 'token')
                ->where('token.valid < :date')
                ->setParameter('date', $date)
                ->orderBy('token.valid', 'ASC')
                ->setMaxResults(20); // Limiter à 20 résultats
            
            $tokens = $detailsQuery->getQuery()->getResult();
            
            $io->section('Détails des tokens à supprimer (premiers 20):');
            $rows = [];
            foreach ($tokens as $token) {
                $rows[] = [
                    $token['username'],
                    substr($token['refreshToken'], 0, 20) . '...',
                    $token['valid']->format('Y-m-d H:i:s')
                ];
            }
            $io->table(['Utilisateur', 'Token (début)', 'Expire le'], $rows);
        }
        
        // 3. Demander confirmation si pas en dry-run
        if (!$dryRun && $input->isInteractive()) {
            $confirm = $io->confirm(sprintf(
                'Voulez-vous vraiment supprimer %d tokens?',
                $count
            ), false);
            
            if (!$confirm) {
                $io->note('Opération annulée.');
                return Command::SUCCESS;
            }
        }
        
        // 4. Exécuter ou simuler
        if ($dryRun) {
            $io->success(sprintf(
                'DRY-RUN: %d tokens seraient supprimés.',
                $count
            ));
            
            // Log de simulation
            $this->logOperation($count, $date, true);
        } else {
            // Suppression réelle
            $deleteQuery = $this->entityManager->createQueryBuilder();
            $deleted = $deleteQuery
                ->delete(RefreshToken::class, 'token')
                ->where('token.valid < :date')
                ->setParameter('date', $date)
                ->getQuery()
                ->execute();
            
            $io->success(sprintf(
                '%d tokens ont été supprimés avec succès.',
                $deleted
            ));
            
            // Log de l'opération réelle
            $this->logOperation($deleted, $date, false);
        }
        
        return Command::SUCCESS;
    }
    
    private function logOperation(int $count, \DateTime $date, bool $dryRun): void
    {
        $logDir = dirname(__DIR__, 2) . '/var/log';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        $logFile = $logDir . '/token_cleanup.log';
        $message = sprintf(
            "[%s] %s - Tokens: %d | Avant date: %s\n",
            date('Y-m-d H:i:s'),
            $dryRun ? 'SIMULATION' : 'SUPPRESSION',
            $count,
            $date->format('Y-m-d H:i:s')
        );
        
        file_put_contents($logFile, $message, FILE_APPEND);
    }
}