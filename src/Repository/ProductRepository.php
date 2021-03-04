<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findFeatured(bool $status){
        return $this->createQueryBuilder('p')
                ->where('p.featured = :status')
                ->setParameter('status', $status)
                ->getQuery()
                ->getResult()
                ;
    }

    public function persist(Product $entity){
        $this->getEntityManager()->persist($entity);
    }
    
    public function flush(){
        $this->getEntityManager()->flush();
    }

    public function delete(Product $entity){
        $this->getEntityManager()->remove($entity);
    }
}
