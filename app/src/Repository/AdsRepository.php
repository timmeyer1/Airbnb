<?php

namespace App\Repository;

use App\Entity\Ads;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ads>
 *
 * @method Ads|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ads|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ads[]    findAll()
 * @method Ads[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ads::class);
    }

    public function findAllWithImages()
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.typeId', 't')
            ->addSelect('t')
            ->leftJoin('a.user_id', 'u')
            ->addSelect('u')
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->getQuery()
            ->getResult();
    }

    public function findByIdWithInfos($id)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.typeId', 't')
            ->addSelect('t')
            ->leftJoin('a.user_id', 'u')
            ->addSelect('u')
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }


    //    /**
    //     * @return Ads[] Returns an array of Ads objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ads
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
