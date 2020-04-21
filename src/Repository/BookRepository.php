<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param int $id
     * @return Book[] Returns an array of Book objects
     */
    public function findByAuthorId(int $id): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.author = :val')
            ->setParameter('val', $id)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
