<?php
namespace App\Services;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

class AuthorService
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
     * @return Author[]
     */
    public function getAuthors(): array
    {
        return $this->entityManager
            ->getRepository(Author::class)
            ->findAll();
    }

    /**
     * @param array $criteria
     * @return Author[]
     */
    public function getBy(array $criteria): array
    {
        return $this->entityManager
            ->getRepository(Author::class)
            ->findBy($criteria);
    }

    /**
     * @param $author
     * @throws ORMException
     */
    public function save($author): void
    {
        try {
            $this->entityManager->persist($author);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            throw new ORMException($e->getMessage());
        }
    }

    /**
     * @param $authorId
     * @return object|null
     */
    public function getById($authorId)
    {
        return $this->entityManager
            ->getRepository(Author::class)
            ->find($authorId);
    }

    /**
     * @param int $id
     * @throws ORMException
     */
    public function delete(int $id): void
    {
        $book = $this->entityManager
            ->getRepository(Author::class)
            ->find($id);
        try {
            $this->entityManager->remove($book);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            throw new ORMException($e->getMessage());
        }
    }

}
