<?php

namespace App\Repository;

use App\Entity\Companies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Companies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Companies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Companies[]    findAll()
 * @method Companies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Companies::class);
        $this->manager=$manager;
    }

    /**
     *
     * @param $name
     * @param $unique_code
     * @param $description
     * @param $logo
     */
    public function saveCompanies($name,$unique_code,$description,$logo){
        $newCompanies=new Companies();
        $newCompanies->setName($name)
            ->setUniqueCode($unique_code)
            ->setDescription($description)
            ->setLogo($logo);
        $this->manager->persist($newCompanies);
        $this->manager->flush();
    }

    public function updateCompanies(Companies $companies): Companies
    {
        $this->manager->persist($companies);
        $this->manager->flush();

        return $companies;
    }
    // /**
    //  * @return Companies[] Returns an array of Companies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Companies
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
