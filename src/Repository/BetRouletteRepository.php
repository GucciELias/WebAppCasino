<?php

namespace App\Repository;

use App\Entity\BetRoulette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BetRoulette>
 *
 * @method BetRoulette|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetRoulette|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetRoulette[]    findAll()
 * @method BetRoulette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetRouletteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetRoulette::class);
    }

//    /**
//     * @return BetRoulette[] Returns an array of BetRoulette objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BetRoulette
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findCurrentBetByUserId($status, $userId): array
    {
        return $this->createQueryBuilder('br')
            ->andWhere('br.status = :status')
            ->andWhere('br.user = :userId') // Ici, utilisez 'user' au lieu de 'user_id'
            ->setParameter('status', $status)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function findBySessionId($sessionId): array
    {
        return $this->createQueryBuilder('br') // 'br' est l'alias pour BetRoulette
        ->where('br.sessionId = :sessionId') // Utilisez le champ sessionId pour filtrer
        ->setParameter('sessionId', $sessionId) // Définissez la valeur du paramètre sessionId
        ->getQuery() // Obtenez la requête à partir du constructeur de requête
        ->getResult(); // Exécutez la requête et obtenez le résultat
    }


}
