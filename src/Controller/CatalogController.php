<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CatalogHandler;
use App\Service\CatalogProvider;

class CatalogController extends AbstractController
{ 
    CONST DEFAULT_PAGE = 1;
    
    /**
     * @Route("/catalog/add", name="add", methods={"POST"})
     * @param Request $request
     * @param CatalogHandler $catalogHandler
     * @return JsonResponse
     */
    public function addToCatalog(Request $request, CatalogHandler $catalogHandler) 
    {
        $parameters = json_decode($request->getContent(), true);
        
        try {
            if (empty($parameters)) {
                throw new \Exception('Wrong parameters');
            }
            
            $catalog = $catalogHandler->create($parameters);

            return new JsonResponse(array(
                'success' => true,
                'catalog' => $catalog
            ), 200);

        } catch (\Exception $e) {
            return new JsonResponse(array(
                'success' => false,
                'message'  => $e->getMessage()
            ), 200);
        }
    }
    
    /**
    * @Route("/catalog/{id}", name="delete_catalog", requirements={"id": "\d+"}, methods={"DELETE"})
    * @param CatalogHandler $catalogHandler
    * @return JsonResponse
    */
    public function removeFromCatalog($id, CatalogHandler $catalogHandler)
    {
        try { 
            $catalogHandler->remove($id);

            return new JsonResponse(array(
                'success' => true
            ), 200);

        } catch (\Exception $e) {
            return new JsonResponse(array(
                'success' => false,
                'message'  => $e->getMessage()
            ), 200);
        }
    }
    
    /**
    * @Route("/catalog/{id}/name/{name}", name="update_product_name", requirements={"id": "\d+"}, methods={"PATCH"})
    * @param CatalogHandler $catalogHandler
    * @return JsonResponse
    */
    public function updateProductName($id, $name, CatalogHandler $catalogHandler)
    {
        try {
            if (empty($name)) {
                throw new \Exception('Wrong parameters');
            }
            
            $catalogHandler->updateTitle($id, $name);

            return new JsonResponse(array(
                'success' => true
            ), 200);

        } catch (\Exception $e) {
            return new JsonResponse(array(
                'success' => false,
                'message'  => $e->getMessage()
            ), 200);
        }
    }
    
    /**
    * @Route("/catalog/{id}/price/{price}", name="update_product_price", requirements={"id": "\d+"}, methods={"PATCH"})
    * @param CatalogHandler $catalogHandler
    * @return JsonResponse
    */
    public function updateProductPrice($id, $price, CatalogHandler $catalogHandler)
    {
        try {
            if (empty($price)) {
                throw new \Exception('Wrong parameters');
            }
            
            $catalogHandler->updatePrice($id, $price);

            return new JsonResponse(array(
                'success' => true
            ), 200);

        } catch (\Exception $e) {
            return new JsonResponse(array(
                'success' => false,
                'message'  => $e->getMessage()
            ), 200);
        }
    }
    
    /**
    * @Route("/catalog", name="list_catalog", methods={"GET"})
    * @param CatalogProvider $catalogProvider
    * @return JsonResponse
    */
    public function listProducts(Request $request, CatalogProvider $catalogProvider) 
    {
        $page = $request->query->get('page', 1);
       
        try {       
            return new JsonResponse(array(
                'success' => true,
                'data' => $catalogProvider->getCatalogData(
                   empty($page) ? self::DEFAULT_PAGE : $page
                )
            ), 200);

        } catch (\Exception $e) {
            return new JsonResponse(array(
                'success' => false,
                'message'  => $e->getMessage()
            ), 200);
        }
    }
}