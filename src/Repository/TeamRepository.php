<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }


    // /**
    //  * @return Team[] Returns an array of Team objects
    //  */
    public function findOneBySlugAndLevel($user, $slug, $level): ?Team
    {
        return $this->createQueryBuilder('t')
            ->addSelect('l')
            ->leftJoin('t.level', 'l')
            ->andWhere('t.owner = :user')
            ->andWhere('t.slug = :slug')
            ->andWhere('l.name = :level')
            ->setParameter('user', $user)
            ->setParameter('slug', $slug)
            ->setParameter('level', $level)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
