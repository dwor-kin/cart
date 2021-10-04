<?php
namespace App\Service;

use App\Repository\CatalogRepository;

class CatalogProvider
{
    /**
     * @var CatalogRepository
     */
    private $catalogRepository;

    /**
     * @param CatalogRepository $catalogRepository
     */
    public function __construct(CatalogRepository $catalogRepository)
    {
        $this->catalogRepository = $catalogRepository;
    }

    /**
     * @return array
     */
    public function getCatalogData(int $page): array 
    {
        return $this->catalogRepository->getPaginatedData($page);
    }
}