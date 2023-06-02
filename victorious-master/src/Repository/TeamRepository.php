<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Team $entity, bool $flush = true): void
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
    public function remove(Team $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Team[] Returns an array of Team objects
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
    public function findOneBySomeField($value): ?Team
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    function Search($teamDesciption){
        return $this->createQueryBuilder('c')
         ->Where('c.teamDesciption LIKE :esport')
         ->setParameter('teamDesciption','%'.$esport.'%')
         ->getQuery()->getResult();
    }
    function orderby(){
        $qb = $this->createQueryBuilder('team')
                   ->orderby('team.players','ASC')
                   ->setMaxResults('5');
 
        return $qb->getQuery()->getResult();                        
    }
    function jointeam(){
        $qb = $connection->createQueryBuilder();
        
    }
    function orderbyname(){
        $qb = $this->createQueryBuilder('team')
                   ->orderby('team.teamName','ASC')
                  ;
 
        return $qb->getQuery()->getResult();                        
    }
    function orderbyplayer(){
        $qb = $this->createQueryBuilder('team')
                   ->orderby('team.players','ASC')
                  ;
 
        return $qb->getQuery()->getResult();                        
    }
}
