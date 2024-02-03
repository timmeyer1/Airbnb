<?php

namespace App\Repository;

use App\Entity\Ads;
use App\Entity\User;
use App\Model\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    // fonction pour sélectionner les équipements avec l'id de leur annonce
    public function findEquipmentsByAdId(int $adId)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.equipment', 'e')
            ->andWhere('a.id = :adId')
            ->setParameter('adId', $adId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // fonction pour sélectionner toutes les annonces avec leurs images
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

    // fonction pour sélectionner une seule annonce avec ses infos
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

    // fonction pour récupérer toutes les annonces créées par l'utilisateur
    public function findAllByUserId($userId)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.user_id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function findAdById(int $id): ?Ads
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

    // récupérer toutes les annonces likes
    public function findAllLikesByUser(User $user)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.likes', 'l')
            ->addSelect('l')
            ->where(':user MEMBER OF a.likes')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
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
