<?php

namespace App\Repository;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query;
use App\Entity\Freelance;
use App\Entity\CodingLanguage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry)
    {
        $this->em = $em;
        parent::__construct($registry, Freelance::class);
    }

    /**
     * Récupère les freelances en lien avec une recherche
     * @return Freelance[]
     */
    public function findSearch(array $parameters): Query //parameters est le tableau
    {
        $qb = $this->createQueryBuilder('f');
        // fait une requête sur l'entité 'F' : 'FREELANCE'



        if (!empty($parameters['language'])) {
            $qb->andWhere('c.id LIKE :id')
                ->setParameter('id', "%{$parameters['language']}%");
        }
        if (!empty($parameters['framework'])) {
            $qb->andWhere('fw.id LIKE :id')
                ->setParameter('id', "%{$parameters['framework']}%");
        }

        if (!empty($parameters['city'])) {
            $qb->andWhere('f.city = :city')
                ->setParameter('city', $parameters['city']);
        }

        $qb->leftJoin('f.codingLanguages', 'c');
        $qb->leftJoin('f.frameworks', 'fw');
        //dd($qb->getDQL());
        // requete bdd



        return $qb->getQuery();
            //->getResult(); //retourne le tableau des résultats
    }

    /**
     * @throws Exception
     */
    public function findSearch2(array $parameters): Query
    {

        $qb = $this->createQueryBuilder('f');
        $qb->join('f.codingLanguages', 'c');

        if (!empty($parameters['language'])) {
            $qb->andWhere('c.nameCodingLanguage LIKE :name')
                ->setParameter('name', "%{$parameters['language']}%");
        }


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
