<?php

namespace App\Repository;

use App\Entity\RouletteGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RouletteGame>
 *
 * @method RouletteGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method RouletteGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method RouletteGame[]    findAll()
 * @method RouletteGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RouletteGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RouletteGame::class);
    }

//    /**
//     * @return RouletteGame[] Returns an array of RouletteGame objects
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

//    public function findOneBySomeField($value): ?RouletteGame
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
