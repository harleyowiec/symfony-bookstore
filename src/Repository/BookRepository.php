<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        $query = $this->createQueryBuilder('b');

        if (!empty($criteria['author'])) {
            $query->andWhere('b.author = :author')
                ->setParameter('author', $criteria['author']->getId());
        }

        if (!empty($criteria['name'])) {
            $query->andWhere('b.name LIKE :name')
                ->setParameter('name', '%'.$criteria['name'].'%');
        }

        return $query->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->execute();
    }
}
