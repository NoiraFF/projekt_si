<?php

/**
 * Item repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ItemRepository.
 *
 * @extends ServiceEntityRepository<Item>
 */
class ItemRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->createQueryBuilder('item')
            ->select(
                'partial item.{id, createdAt, description, title}',
                'partial category.{id, title}'
            )
            ->join('item.category', 'category');
    }

    /**
     * Count items by category.
     *
     * @param Category $category Category
     *
     * @return int Number of items in category
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->CreateQueryBuilder('item');

        return $qb->select($qb->expr()->countDistinct('item.id'))
            ->where('item.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Save entity.
     *
     * @param Item $item Item entity
     */
    public function save(Item $item): void
    {
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();
    }

    /**
     * Delete entity.
     *
     * @param Item $item Item entity
     */
    public function delete(Item $item): void
    {
        $this->getEntityManager()->remove($item);
        $this->getEntityManager()->flush();
    }

    //    /**
    //     * @return Item[] Returns an array of Item objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Item
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
