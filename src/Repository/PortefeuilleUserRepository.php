<?php

namespace App\Repository;

use App\Entity\PortefeuilleUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortefeuilleUser>
 *
 * @method PortefeuilleUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortefeuilleUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortefeuilleUser[]    findAll()
 * @method PortefeuilleUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortefeuilleUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortefeuilleUser::class);
    }

//    /**
//     * @return PortefeuilleUser[] Returns an array of PortefeuilleUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PortefeuilleUser
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    public function findByUserId($userId)
    {
        return $this->createQueryBuilder('p')
            ->where('p.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
