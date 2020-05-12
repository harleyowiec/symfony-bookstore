<?php
namespace App\Services;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

class BookService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Book[]
     */
    public function getBooks(): array
    {
        return $this->entityManager
            ->getRepository(Book::class)
            ->findAll();
    }

    /**
     * @param array $criteria
     * @return Book[]
     */
    public function getBy(array $criteria): array
    {
        return $this->entityManager
            ->getRepository(Book::class)
            ->findBy($criteria);
    }

    /**
     * @param $book
     * @throws ORMException
     */
    public function save($book): void
    {
        try {
            $this->entityManager->persist($book);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            throw new ORMException($e->getMessage());
        }
    }

    /**
     * @param $bookId
     * @return object|null
     */
    public function getById($bookId)
    {
        return $this->entityManager
            ->getRepository(Book::class)
            ->find($bookId);
    }

    /**
     * @param int $id
     * @throws ORMException
     */
    public function delete(int $id): void
    {
        $book = $this->entityManager
            ->getRepository(Book::class)
            ->find($id);
        try {
            $this->entityManager->remove($book);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            throw new ORMException($e->getMessage());
        }
    }
}
