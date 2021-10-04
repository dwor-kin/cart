<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Catalog;

class CatalogRepository extends ServiceEntityRepository
{
    /**
     * @param RegistryInterface $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalog::class);
    }

    /**
     * @param Catalog $catalog
     * @return Catalog
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Catalog $catalog): Catalog
    {
        $em = $this->getEntityManager();

        $em->beginTransaction();
        
        try {
            $em->persist($catalog);
            $em->flush();
            $em->commit();
            
            return $catalog;
        } catch (Exception $e) {
            $em->rollback();
            throw new \Exception($e);
        }
    }

    public function remove(Catalog $catalog)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();
        
        try {
            $em->remove($catalog);
            $em->flush();
            $em->commit();
        } catch (Exception $e) {
            $em->rollback();
            throw new \Exception($e);
        }
    }

    /** @inheritDoc */
    public function update(Catalog $catalog)
    {
        $em = $this->getEntityManager();

        $em->beginTransaction();
        
        try {
            $em->merge($catalog);
            $em->flush();
            $em->commit();
        } catch (Exception $e) {
            $em->rollback();
            throw new \Exception($e);
        }
    }
    
    /**
     * 
     * @param int $page
     * @return type
     */
    public function getPaginatedData(int $page) 
    {
        $maxResult = 3;
        $firstResult = ($page - 1) * $maxResult;
        
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c')
            ->from('App\Entity\Catalog', 'c')    
            ->setMaxResults($maxResult)
            ->setFirstResult($firstResult);
        
        return $query->getQuery()->getResult();
    }
}