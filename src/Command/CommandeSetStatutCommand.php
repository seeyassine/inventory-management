<?php

namespace App\Command;

use App\Entity\Commande;
use App\Enum\StatutCommande;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:commande:set-statut',
    description: 'Changer le statut d’une commande donn��e',
)]
class CommandeSetStatutCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'ID de la commande')
            ->addArgument('statut', InputArgument::REQUIRED, 'Nouveau statut de la commande')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commande = $this->em->getRepository(Commande::class)
            ->find($input->getArgument('id'));

        if (!$commande) {
            $output->writeln('<error>Commande introuvable</error>');
            return Command::FAILURE;
        }

        $statut = StatutCommande::tryFrom($input->getArgument('statut'));

        $available = array_map(fn($s) => $s->value, StatutCommande::cases());

        if (!$statut) {
            $output->writeln('<error>Statut invalide</error>');
            $output->writeln('Statuts disponibles : ' . implode(', ', $available));
            return Command::FAILURE;
        }

        $commande->setStatut($statut);
        $this->em->flush();

        $output->writeln('<info>Statut mis à jour avec succès</info>');

        return Command::SUCCESS;
    }
}
