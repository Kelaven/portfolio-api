<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin-user',
    description: 'Creates a new admin user',
)]
class CreateAdminUserCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = 'kevin.lavenant@live.fr';

        // Récupère le mot de passe depuis les variables d'environnement
        $password = $_ENV['ADMIN_PASSWORD'];

        if (!$password) {
            $io->error("Le mot de passe administrateur n'est pas défini. Assurez-vous que la variable ADMIN_PASSWORD est configurée dans .env.local.");
            return Command::FAILURE;
        }

        $user = new User();
        $user->setEmail($username); // Utilise l'email comme identifiant
        $user->setRoles(['ROLE_ADMIN']); // Attribue le rôle administrateur
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('Utilisateur administrateur créé avec succès.');

        return Command::SUCCESS;
    }
}
