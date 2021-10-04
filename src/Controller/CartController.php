<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CartHandler;
use App\Service\CartProvider;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add/{productId}", name="add_cart", requirements={"productId": "\d+"}, methods={"POST"})
     * @param CartHandler $cartHandler
     * @return JsonResponse
     */
    public function addToCart($productId, CartHandler $cartHandler) 
    {
        try {
            $catalog = $cartHandler->addToCart($productId);

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
    * @Route("/cart/{productId}", name="remove_from_cart", requirements={"productId": "\d+"}, methods={"DELETE"})
    * @param CartHandler $cartHandler
    * @return JsonResponse
    */
    public function removeFromCart($productId, CartHandler $cartHandler)
    {
        try { 
            $products = $cartHandler->remove($productId);

            return new JsonResponse(array(
                'success' => true,
                'catalog' => $products
            ), 200);

        } catch (\Exception $e) {
            return new JsonResponse(array(
                'success' => false,
                'message'  => $e->getMessage()
            ), 200);
        }
    }
    
    /**
     * @Route("/cart/purge", name="purge_cart", methods={"GET"})
     * @param CartHandler $cartHandler
     * @return JsonResponse
     */
    public function purgeCart(CartHandler $cartHandler) 
    {
        try {
            $cartHandler->purge();

            return new JsonResponse(array(
                'success' => true,
            ), 200);

        } catch (\Exception $e) {
            return new JsonResponse(array(
                'success' => false,
                'message'  => $e->getMessage()
            ), 200);
        }
    }
    
    /**
     * @Route("/cart/list", name="list_cart", methods={"GET"})
     * @param CartProvider $cartProvider
     * @return JsonResponse
     */
    public function listFromTheCart(CartProvider $cartProvider)
    {
        try {
            return new JsonResponse(array(
                'success' => true,
                'catalog' => $cartProvider->getCartData()
            ), 200);

        } catch (\Exception $e) {
            return new JsonResponse(array(
                'success' => false,
                'message'  => $e->getMessage()
            ), 200);
        } 
    }
}