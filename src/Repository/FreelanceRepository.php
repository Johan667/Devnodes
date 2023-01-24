<?php

namespace App\Repository;

use App\Entity\Freelance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Freelance>
 *
 * @method Freelance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Freelance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Freelance[]    findAll()
 * @method Freelance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreelanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Freelance::class);
    }

    /**
     * Récupère les événement en lien avec une recherche
     * @return Freelance[]
     */
    public function findSearch(array $parameters): Query //parameters est le tableau
    {
        $qb = $this->createQueryBuilder('F');
        // fait une requête sur l'entité 'F' : 'FREELANCE'

        if ($parameters['q'] !== null) {
            // si le titre est différent de null une fois submit, on le cherche içi :
            $qb->andWhere('F.title LIKE :title')
                ->setParameter('title', "%{$parameters['q']}%");
            // lie 'q' du tableau $parameter au title de la table user // bindParamPDO
        }

        if ($parameters['city'] !== null) {
           $qb->andWhere('F.city = :city')
                ->setParameter('city', $parameters['city']);
        }

        // requete bdd

        return $qb->getQuery();
            //->getResult(); //retourne le tableau des résultats
    }

    /**
     * @return Query
     */
    public function findAllNotSoldQuery(): Query
    {
        return $this->findNotSoldQuery()
            ->getQuery()
            ;
    }



    public function save(Freelance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Freelance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Freelance[] Returns an array of Freelance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Freelance
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
