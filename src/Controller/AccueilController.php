<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/register', name: 'app_accueil_register')]
    public function register(Request $request, ObjectManager $objectManager,UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {

        $champs = [
            ['id' => 'nom', 'label' => 'Nom', 'valeur' => '', 'type' => 'text'],
            ['id' => 'prenom', 'label' => 'Prénom', 'valeur' => '', 'type' => 'text'],
            ['id' => 'email', 'label' => 'E-mail', 'valeur' => '', 'type' => 'text'],
            ['id' => 'ddn', 'label' => 'Date de naissance', 'valeur' => '', 'type' => 'date'],
            ['id' => 'telephone', 'label' => 'Téléphone', 'valeur' => '', 'type' => 'text'],
            ['id' => 'adresse', 'label' => 'Adresse', 'valeur' => '', 'type' => 'text'],
            ['id' => 'ville', 'label' => 'Ville', 'valeur' => '', 'type' => 'text'],
            ['id' => 'cp', 'label' => 'Code Postale', 'valeur' => '', 'type' => 'text'],
            ['id' => 'password', 'label' => 'Mot de passe', 'valeur' => '', 'type' => 'password'],
            ['id' => 'confirm_password', 'label' => 'Confirmez le mot de passe', 'valeur' => '', 'type' => 'password'],
        ];

        if ($request->isMethod('POST')){


            $password = $request->get('password');
            $confirmPassword = $request->get('confirm_password');

            $birthdate = new \DateTime($request->get('ddn'));
            $today = new \DateTime('now');
            $age = $today->diff($birthdate)->y;


            if ($password === $confirmPassword){

                if ($age < 18){
                    $this->addFlash('danger', 'Vous devez avoir au moins 18 ans pour vous inscrire.');
                    return $this->redirectToRoute('app_accueil');
                }

                if (strlen($password) < 12) {
                    $this->addFlash('danger', 'Le mot de passe est trop court');
                    return $this->redirectToRoute('app_accueil');
                } if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/\W/', $password)) {
                    $this->addFlash('danger', 'Le mot de passe doit contenir une minuscule, une majuscule, un chiffre et un caractère spécial');
                    return $this->redirectToRoute('app_accueil');
                }

                if ($userRepository->findOneByEmail($request->get('email'))){

                    $this->addFlash('danger', 'Utilisateur déja inscrit');
                    return $this->redirectToRoute('app_accueil');
                }

                else {

                    $user = new User();


                    $hashedPassword = $passwordHasher->hashPassword($user, $password);

                    $user->setNom($request->get('nom'));
                    $user->setPrenom($request->get('prenom'));
                    $user->setEmail($request->get('email'));
                    $user->setBirthDate($birthdate);
                    $user->setTelephone($request->get('telephone'));
                    $user->setAdresse($request->get('adresse'));
                    $user->setVille($request->get('ville'));
                    $user->setCp($request->get('cp'));
                    $user->setPassword($hashedPassword);
                    $user->setRoles(['ROLE_USER']);

                    $objectManager->persist($user);
                    $objectManager->flush();

                    return $this->redirectToRoute('app_login');

                }

            }
        }

        return $this->render('accueil/register.html.twig', [
            'controller_name' => 'AccueilController',
            'champs' => $champs,
        ]);
    }

}
