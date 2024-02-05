<?php

namespace App\Controller;

use App\Entity\PortefeuilleUser;
use App\Repository\PortefeuilleUserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PortefeuilleUserRepository $portefeuilleUser): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $walletUser = $portefeuilleUser->findByUserId($userId);


        if (!$walletUser){

            return $this->redirectToRoute('app_home_fwallet');
        }


        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'solde' => $walletUser->getSolde(),
            'walletuser' => $walletUser,

        ]);
    }


    #[Route('/home/fwallet', name: 'app_home_fwallet')]
    public function firstwallet(PortefeuilleUserRepository $portefeuilleUser, Request $request, ObjectManager $objectManager): Response
    {

        $user = $this->getUser();
        $userId = $user->getId();
        $walletUser = $portefeuilleUser->findByUserId($userId);

        $champs = [
            ['id' => 'montant', 'label' => 'Montant', 'valeur' => '', 'type' => 'text'],
            ['id' => 'codec', 'label' => 'Code de la carte', 'valeur' => '', 'type' => 'text'],
            ['id' => 'datec', 'label' => 'Date d\'expiration', 'valeur' => '', 'type' => 'month'], // Changé en 'month'
            ['id' => 'ccv', 'label' => 'CCV', 'valeur' => '', 'type' => 'text'],
            ['id' => 'namec', 'label' => 'Nom sur la carte', 'valeur' => '', 'type' => 'text'],
        ];

        if ($request->isMethod('POST')){

            (int)$montant = $request->get('montant');

            $transac = ['+',$montant];

            if ($montant > 500){
                $this->addFlash('danger', 'Vous ne pouvez pas mettre plus de 500€ en une seule fois');
            }

            else{

                $wallet = new PortefeuilleUser();

                $wallet->setSolde($montant);
                $wallet->setTransaction($transac);
                $wallet->setUserId($user);

                $objectManager->persist($wallet);
                $objectManager->flush();

                return $this->redirectToRoute('app_home');

            }

        }

        return $this->render('home/firstwallet.html.twig', [
            'controller_name' => 'HomeController',
            'champs' => $champs,
            'walletuser' => $walletUser,


        ]);
    }


}
