<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
    * @return Stage[] Returns an array of Stage objects
    */
    public function findStagesParNomEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
                    ->select('s,e')
                    ->join('s.entreprise', 'e')
                    ->andWhere('e.nom = :nomEntreprise')
                    ->setParameter('nomEntreprise', $nomEntreprise)
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
    * @return Stage[] Returns an array of Stage objects
    */
    public function findStagesParNomCourtFormation($nomCourtFormation)
    {
        // Récupération du gestionnaire d'entité
        $gestionnaireEntite = $this->getEntityManager();
        
        // Construction de la requête
        $requete = $gestionnaireEntite->createQuery(
                "SELECT s,e
                FROM App\Entity\Stage s
                JOIN s.entreprise e
                JOIN s.formations f
                WHERE f.nomCourt = '$nomCourtFormation'"
            );

        // Exécution de la requête et retour des résultats
        return $requete->execute();
    }

    /**
    * @return Stage[] Returns an array of Stage objects
    */
    public function findStagesEtEntreprises()
    {
        return $this->createQueryBuilder('s')
                    ->select('s,e')
                    ->join('s.entreprise', 'e')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
    * @return Stage Returns a Stage object
    */
    public function findStageEntrepriseEtFormations($idStage)
    {
        return $this->createQueryBuilder('s')
                    ->select('s,e,f')
                    ->join('s.entreprise', 'e')
                    ->join('s.formations', 'f')
                    ->andWhere('s.id = :idStage')
                    ->setParameter('idStage', $idStage)
                    ->getQuery()
                    ->getOneOrNullResult()
        ;
    }
}