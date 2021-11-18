<?php

namespace App\Repository;

use App\DTO\SearchCriteria;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function findLast(int $number=10):array
    {
        return $this->createQueryBuilder('livre')
            ->orderBy('livre.datedemisejour', 'DESC')
            ->setMaxResults($number)
            ->getQuery()
            ->getResult();
    }

    public function findLivresCriteria(SearchCriteria $searchCriteria): array
    {
        $queryBuider = $this
            ->createQueryBuilder('livre')
            ->setFirstResult($searchCriteria->limit * ($searchCriteria->page -1))
            ->setMaxResults($searchCriteria->limit)
            ->orderBy("livre.{$searchCriteria->orderBy}", $searchCriteria->direction);

        if ($searchCriteria->titre) {
            $queryBuider = $queryBuider
                ->andWhere('livre.titre LIKE :titre')
                ->setParameter('titre', "%{$searchCriteria->titre}%");
        }

        if ($searchCriteria->minPrix) {
            $queryBuider = $queryBuider
                ->andWhere('livre.prix >= :minPrix')
                ->setParameter('minPrix', $searchCriteria->minPrix);
        }

        if ($searchCriteria->maxPrix) {
            $queryBuider = $queryBuider
                ->andWhere('livre.prix <= :maxPrix')
                ->setParameter('maxPrix', $searchCriteria->maxPrix);
        }

        if ($searchCriteria->auteur) {
            $queryBuider = $queryBuider
                ->leftJoin('livre.auteur', 'auteur')
                ->andWhere('CONCAT(auteur.prenom, CONCAT(\'\', auteur.nom)) LIKE :auteur')
                ->setParameter('auteur', "%{$searchCriteria->auteur}%");
        }

        if ($searchCriteria->categorie) {
            $queryBuider = $queryBuider
                ->leftJoin('livre.categorie', 'categorie')
                ->andWhere('categorie.titre LIKE :categorie')
                ->setParameter('categorie', "%{$searchCriteria->categorie}%");
        }

        if ($searchCriteria->revendeur) {
            $queryBuider = $queryBuider
                ->leftJoin('livre.revendeur', 'revendeur')
                ->andWhere('revendeur.email LIKE :revendeur')
                ->setParameter('revendeur', "%{$searchCriteria->revendeur}%");
        }

        return $queryBuider->getQuery()->getResult();


        



    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
