<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
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

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    /**
     * @return Product[]
     */
    public function findAllOfCategory($category): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Product p
            INNER JOIN p.category c
            WHERE c.name :category
            ORDER BY p.price ASC'
        )->setParameter(Category, $category);

        // returns an array of Product objects
        return $query->getResult();
    }
    
    /**
     * @return Product[]
     */
    public function findNewProducts(): array
    {
        $entityManager = $this->getEntityManager();
        $today = new \DateTime();
        $dateSubMonth = $today->sub(new \DateInterval('P2M'));
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Product p
            WHERE p.addedDate >= :pAddedDate
            ORDER BY p.addedDate ASC'
        )->setParameter('pAddedDate', $dateSubMonth);

        // returns an array of Product objects
        return $query->getResult();
    }
    
    public function findProductsInPromotion(): array
    {
        $entityManager = $this->getEntityManager();
        $today = new \DateTime();
        $dateSubMonth = $today->sub(new \DateInterval('P2M'));
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Product p
            WHERE p.onDiscount = :pInDiscount
            ORDER BY p.addedDate ASC'
        )->setParameter('pInDiscount', true);

        // returns an array of Product objects
        return $query->getResult();
    }

//    /**
//     * @return Product[] Returns an array of Product objects
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

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
