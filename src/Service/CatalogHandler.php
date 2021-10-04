<?php
namespace App\Service;

use App\Builder\CatalogBuilder;
use App\Entity\Catalog;
use App\Repository\CatalogRepository;
use Symfony\Component\Form\FormInterface;

class CatalogHandler
{
    /** @var CatalogRepository */
    private $catalogRepository;
    
    /** @var CatalogBuilder */
    private $catalogBuilder;

    public function __construct(
        CatalogRepository $catalogRepository,
        CatalogBuilder $catalogBuilder    
    ) {
        $this->catalogRepository = $catalogRepository;
        $this->catalogBuilder = $catalogBuilder;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function remove($id): void
    {
        $catalog = $this->catalogRepository->findOneBy(["id" => $id]);

        if (!$catalog instanceof Catalog) {
            throw new \Exception('Wrong catalog number');
        }

        $this->catalogRepository->remove($catalog);
    }

    /**
     * @param array $parameters
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(array $parameters): Catalog
    {
        $catalog = $this->catalogBuilder->build(
            $parameters['title'],
            (float)$parameters['price']
        );

        $this->catalogRepository->create($catalog);
        
        return $catalog;
    }

    /**
     * @param int $id
     * @param string $title
     * @throws \Exception
     */
    public function updateTitle(int $id, string $title): void
    {
        $catalog = $this->catalogRepository->findOneBy(['id' => $id]);

        if (!$catalog instanceof Catalog) {
            throw new \Exception ('That catalog does not exist!');
        }

        $catalog->setTitle($title);
        $this->catalogRepository->update($catalog);
    }
    
    /**
     * @param int $id
     * @param float $price
     * @throws \Exception
     */
    public function updatePrice(int $id, float $price): void
    {
        $catalog = $this->catalogRepository->findOneBy(['id' => $id]);

        if (!$catalog instanceof Catalog) {
            throw new \Exception ('That catalog does not exist!');
        }

        $catalog->setPrice($price);
        $this->catalogRepository->update($catalog);
    }
}