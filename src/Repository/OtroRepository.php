<?php

namespace App\Repository;

use App\Entity\Otro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Otro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Otro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Otro[]    findAll()
 * @method Otro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Otro::class);
    }

    // /**
    //  * @return Otro[] Returns an array of Otro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Otro
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
