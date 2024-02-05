<?php

namespace App\Repository;

use App\Entity\RouletteResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RouletteResult>
 *
 * @method RouletteResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method RouletteResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method RouletteResult[]    findAll()
 * @method RouletteResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RouletteResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RouletteResult::class);
    }

//    /**
//     * @return RouletteResult[] Returns an array of RouletteResult objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RouletteResult
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findOneBySessionId($sessionId): ?RouletteResult
    {
        return $this->createQueryBuilder('rr') // 'rr' est l'alias pour RouletteResult
        ->where('rr.sessionId = :sessionId') // Filtrer par sessionId
        ->setParameter('sessionId', $sessionId) // Définir la valeur du paramètre sessionId
        ->getQuery() // Obtenir la requête à partir du constructeur de requête
        ->getOneOrNullResult(); // Exécuter la requête et obtenir un seul résultat ou null
    }
}
