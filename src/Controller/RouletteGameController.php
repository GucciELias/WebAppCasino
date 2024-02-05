<?php

    namespace App\Controller;

    use App\Entity\BetRoulette;
    use App\Entity\Roulette;
    use App\Entity\RouletteResult;
    use App\Repository\BetRouletteRepository;
    use App\Repository\PortefeuilleUserRepository;
    use App\Repository\RouletteRepository;
    use App\Repository\RouletteResultRepository;
    use App\Repository\UserRepository;
    use Doctrine\Persistence\ObjectManager;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\Routing\Annotation\Route;

    class RouletteGameController extends AbstractController
    {

        #[Route('/roulette', name: 'app_roulette')]
        public function index(PortefeuilleUserRepository $portefeuilleUserRepository, UserRepository $userRepository, Request $request): Response
        {


            $user = $this->getUser();
            $userId = $user->getId();
            $walletUser = $portefeuilleUserRepository->findByUserId($userId);


            return $this->render('home/roulette.html.twig', [
                'controller_name' => 'RouletteGameController',
                'solde' => $walletUser->getSolde(),
                'walletuser' => $walletUser,


            ]);
        }


        #[Route('/roulette/game/{id}/{token}', name: 'app_roulette_game', requirements: ['id' => '\d+'])]
        public function roulette(PortefeuilleUserRepository $portefeuilleUserRepository, $token, $id, UserRepository $userRepository, Request $request): Response
        {

            $user = $this->getUser();
            $userId = $user->getId();
            $walletUser = $portefeuilleUserRepository->findByUserId($userId);

            $session = $request->getSession();
            $session->set('rouletteId', $id);

            return $this->render('roulette_game/index.html.twig', [
                'controller_name' => 'RouletteGameController',
                'solde' => $walletUser->getSolde(),
                'walletuser' => $walletUser,
                'id' => $id,
                'token' => $token,

            ]);
        }


        /**
         * @throws \Exception
         */
        #[Route('/api/roulette/bet', name: 'roulette_bet', methods: ['POST'])]
        public function receiveBet(Request $request, ObjectManager $objectManager, PortefeuilleUserRepository $portefeuilleUserRepository, BetRouletteRepository $betRouletteRepository,SessionInterface $session): JsonResponse
        {
            $user = $this->getUser();
            $userId = $user->getId();
            $walletUser = $portefeuilleUserRepository->findByUserId($userId);
            $actualSolde = $walletUser->getSolde();

            $data = json_decode($request->getContent(), true);

            if (isset($data['bet'])) {
                $totalBetAmount = 0;
                $sessionId = uniqid('game_', true) . bin2hex(random_bytes(5));
                $session->set('SessionId', $sessionId);

                foreach ($data['bet'] as $betItem) {
                    $betAmount = $betItem['amt'];
                    $number = $betItem['numbers'];
                    $betColor = $betItem['colorBet'];

                    $newBet = new BetRoulette();




                    $newBet->setSessionId($sessionId);
                    $newBet->setStatus(1);
                    $newBet->setBetDate(new \DateTime());
                    $newBet->setMontant((int)$betAmount);
                    $newBet->setBetType($betColor);

                    if (!empty($betColor)) {
                        $newBet->setBetNumber(null);
                    } else {
                        $newBet->setBetNumber((int)$number);
                        $newBet->setBetType(null);
                    }

                    $newBet->setUserId($user);

                    $totalBetAmount += $betAmount;

                    $objectManager->persist($newBet);
                }


                $walletUser->setSolde($actualSolde - $totalBetAmount);
                $objectManager->persist($walletUser);
                $objectManager->flush();

                return new JsonResponse(['status' => 'success', 'message' => 'Bet received']);
            } else {
                return new JsonResponse(['status' => 'error', 'message' => 'Bet data not found'], 400);
            }
        }


        #[Route('/api/roulette/result', name: 'roulette_result', methods: ['POST'])]
        public function rouletteResult(Request $request, ObjectManager $objectManager, RouletteResultRepository $rouletteResultRepository, RouletteRepository $rouletteRepository, BetRouletteRepository $betRouletteRepository, PortefeuilleUserRepository $portefeuilleUserRepository, SessionInterface $session): JsonResponse
        {
            date_default_timezone_set('Europe/Paris');

            $data = json_decode($request->getContent(), true);

            if (is_array($data) && isset($data['result']) && isset($data['color'])) {
                $sessionId = $session->get('SessionId');
                $rouletteId = $session->get('rouletteId');

                $roulette = $rouletteRepository->find($rouletteId);

                $rouletteResult = new RouletteResult();
                $result = $data['result'];
                $color = $data['color'];

                $rouletteResult->setSessionId($sessionId);
                $rouletteResult->setColor((string)$color)->setNumber((int)$result);
                $rouletteResult->setRoulette($roulette);
                $rouletteResult->setDateLast(new \DateTimeImmutable());

                $objectManager->persist($rouletteResult);
                $objectManager->flush(); // Assurez-vous d'avoir l'ID de rouletteResult maintenant

                $bets = $betRouletteRepository->findBySessionId($sessionId);

                foreach ($bets as $bet) {
                    $bet->setRouletteResult($rouletteResult); // Associe le résultat de la roulette au pari
                    $objectManager->persist($bet);
                }

                $objectManager->flush(); // Appliquez les modifications une seule fois après toutes les mises à jour

                return $this->compareBetResults($objectManager, $betRouletteRepository, $rouletteResultRepository, $portefeuilleUserRepository, $session);
            } else {
                return new JsonResponse(['status' => 'error', 'message' => 'Invalid data'], 400);
            }
        }







        #[Route('/api/getBankValue', name: 'get_bank_value', methods: ['GET'])]
        public function getBankValue(PortefeuilleUserRepository $portefeuilleUserRepository): JsonResponse
        {
            $user = $this->getUser();
            if (!$user) {
                return new JsonResponse(['status' => 'error', 'message' => 'User not authenticated'], 401);
            }

            $userId = $user->getId();
            $walletUser = $portefeuilleUserRepository->findByUserId($userId);

            if (!$walletUser) {
                return new JsonResponse(['status' => 'error', 'message' => 'Wallet not found'], 404);
            }

            $bankValue = $walletUser->getSolde();

            return new JsonResponse(['status' => 'success', 'bankValue' => $bankValue]);
        }


        /**
         * Compare les paris des utilisateurs avec le résultat de la roulette et met à jour le solde.
         */
        public function compareBetResults(ObjectManager $objectManager, BetRouletteRepository $betRouletteRepository, RouletteResultRepository $rouletteResultRepository, PortefeuilleUserRepository $portefeuilleUserRepository, SessionInterface $session): JsonResponse
        {
            $sessionId = $session->get('SessionId');
            $bets = $betRouletteRepository->findBySessionId($sessionId);
            $result = $rouletteResultRepository->findOneBySessionId($sessionId);

            if (!$result) {
                return new JsonResponse(['status' => 'error', 'message' => 'Result not found'], 404);
            }

            $totalWon = 0;
            $totalLost = 0;

            foreach ($bets as $bet) {
                $user = $bet->getUserId();
                $walletUser = $portefeuilleUserRepository->findByUserId($user->getId());
                $betAmount = $bet->getMontant();
                $isWin = false;

                if ($bet->getBetType() && $bet->getBetType() === $result->getColor()) {
                    $isWin = true;
                } elseif ($bet->getBetNumber() !== null && $bet->getBetNumber() === $result->getNumber()) {
                    $isWin = true;
                }

                if ($isWin) {
                    $winAmount = $this->calculateWinAmount($bet, $result);
                    $totalWon += $winAmount;
                    $newSolde = $walletUser->getSolde() + $winAmount;
                    $walletUser->setSolde($newSolde);
                } else {
                    $totalLost += $betAmount;
                }

                $objectManager->persist($walletUser);
            }

            $objectManager->flush();

            if ($totalWon > 0) {
                $message = "Congratulations! You won a total of €" . $totalWon;
            } else {
                $message = "Sorry! You lost a total of €" . $totalLost;
            }

            return new JsonResponse(['status' => 'success', 'message' => $message, 'totalWon' => $totalWon, 'totalLost' => $totalLost]);
        }


        /**
         * Calcule le montant gagné en fonction du type de pari.
         */
        private function calculateWinAmount(BetRoulette $bet, $result)
        {
            $betAmount = $bet->getMontant();
            $winAmount = 0;

            // Vérifier si le pari est sur un numéro
            if ($bet->getBetNumber() !== null) {
                if ($bet->getBetNumber() === $result->getNumber()) {
                    // Si le pari est sur le numéro correct, le joueur gagne 35 fois son pari
                    $winAmount = $betAmount * 35;
                }
            }
            // Vérifier si le pari est sur une couleur
            else if ($bet->getBetType() === 'red' || $bet->getBetType() === 'black') {
                if ($bet->getBetType() === $result->getColor()) {
                    // Si le pari est sur la couleur correcte, le joueur gagne 1 fois son pari
                    $winAmount = $betAmount * 2; // Le montant parié + le gain
                }
            }

            else if ($bet->getBetType() === 'pair' || $bet->getBetType() === 'impair') {
                if ($bet->getBetType() === $result->getColor()) {
                    // Si le pari est sur la couleur correcte, le joueur gagne 1 fois son pari
                    $winAmount = $betAmount * 2; // Le montant parié + le gain
                }
            }
            // Ajouter ici d'autres conditions de pari si nécessaire

            return $winAmount;
        }




    }
