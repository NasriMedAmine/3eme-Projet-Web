<?php

namespace App\Repository;

use App\Entity\PubliciteAimer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PubliciteAimer|null find($id, $lockMode = null, $lockVersion = null)
 * @method PubliciteAimer|null findOneBy(array $criteria, array $orderBy = null)
 * @method PubliciteAimer[]    findAll()
 * @method PubliciteAimer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PubliciteAimerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PubliciteAimer::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PubliciteAimer $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PubliciteAimer $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PubliciteAimer[] Returns an array of PubliciteAimer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PubliciteAimer
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
