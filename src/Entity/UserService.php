<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class UserService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUserByEmail(string $email): ?User
    {
        // Récupération de l'utilisateur par e-mail
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    // Vous pouvez ajouter d'autres méthodes utiles ici, par exemple pour créer ou mettre à jour des utilisateurs
}