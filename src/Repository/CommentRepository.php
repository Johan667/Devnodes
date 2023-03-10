<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function save(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * trouve les derniers commentaires d'un utilisateur spécifique
     * @param limit pour indiquer le nombre de commentaires que nous recherchons.
     * @param user pour l'utilisateur recherché
     */
    public function findLatest($limit, User $user): array
    {
        return $this->createQueryBuilder('c')
            ->setMaxResults($limit)
            ->andWhere('c.received = :userId')
            ->andWhere('c.parent is NULL')
            ->setParameter(':userId', $user->getId())
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * trouve les restes des commentaires d'un utilisateur spécifique
     * @param offset nous permet de commencer à un certain endroit et de montrer tous les commentaires après cet endroit
     * @param user pour l'utilisateur recherché
     */
    public function findRest($offset, User $user): array
    {
        return $this->createQueryBuilder('c')
            ->setFirstResult($offset)
            ->andWhere('c.received = :userId')
            ->andWhere('c.parent is NULL')
            ->setParameter(':userId', $user->getId())
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Comment[] Returns an array of Comment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Comment
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
