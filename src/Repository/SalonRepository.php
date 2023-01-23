<?php

namespace App\Repository;

use App\Entity\Salon;
use App\Entity\SalonSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Salon>
 *
 * @method Salon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salon[]    findAll()
 * @method Salon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salon::class);
    }

    /**
     * @return Query
     */
    
    public function findAllVisibleQuery(SalonSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getLat() && $search->getLng() && $search->getDistance()) {
            $query = $query
                ->select('p')
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) *  pi()/180 / 2), 2) +COS(p.lat * pi()/180) * COS(:lat * pi()/180) * POWER(SIN((p.lng - :lng) * pi()/180 / 2), 2) ))) <= :distance')
                ->setParameter('lng', $search->getLng())
                ->setParameter('lat', $search->getLat())
                ->setParameter('distance', $search->getDistance());
        }

        if ($search->getTatooStyles()->count() > 0) {
            foreach($search->getTatooStyles() as $k => $tatoo_style) {
                $query = $query
                    ->andWhere(':tatoo_style MEMBER OF p.tatoo_style')
                    ->setParameter('tatoo_style', $tatoo_style);
            }
        }
        return $query->getQuery();
    }

    /**
     * @return Salon[] Returns an array of Salon objects
     */
    
    public function findLatest() : array
    {
        return $this->findVisibleQuery()
        ->setMaxresults(4)
            ->getQuery()
            ->getResult();
    }
    
    public function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }
    

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Salon $entity, bool $flush = true): void
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
    public function remove(Salon $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Salon[] Returns an array of Salon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Salon
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
