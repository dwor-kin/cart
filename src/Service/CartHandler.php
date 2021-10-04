<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\CatalogRepository;
use App\Entity\Catalog;
use App\Service\CartService;

class CartHandler
{
    const MAX_PRODUCT_IN_CART = 3;
        
    /**
     *
     * @var CatalogRepository
     */
    private $catalogRepository;
    
    /**
     *
     * @var CartService
     */
    private $cartService;
    
    /**
     * 
     * @param RequestStack $requestStack
     */
    public function __construct(
        CatalogRepository $catalogRepository, 
        CartService $cartService
    ) {
        $this->catalogRepository = $catalogRepository;
        $this->cartService = $cartService;
    }
    
    /**
     * 
     * @param int $productId
     * @return array
     */
    public function addToCart(int $productId): array 
    {
        /** @var Catalog */
        $catalog = $this->catalogRepository->findOneBy(['id' => $productId]);

        if (!$catalog instanceof Catalog) {
            throw new \Exception ('That product does not exist!');
        }
        
        $cartData = $this->cartService->getCartDataFromSession();
       
        if ($this->checkIsMaxProduct($cartData)) {
            throw new \Exception ('Cannot add more products to cart');
        }
        
        // wstawić sprawdzenie czy jest w koszyku
        $cartData[$productId] = [
            "title" => $catalog->getTitle(),
            "price" => $catalog->getPrice()
        ];
        
        $this->cartService->setCartDataToSession($cartData);
        
        return $cartData;
    }
    
    /**
     * @param int $productId
     * @return array
     */
    public function remove(int $productId): array
    {
        $cartData = $this->cartService->getCartDataFromSession();
        
        if (array_key_exists($productId, $cartData)) {
            unset($cartData[$productId]);
        }
        
        $this->cartService->setCartDataToSession($cartData);
        
        return $this->cartService->decorateCartResponse($cartData);
    }
    
    /**
     * 
     * @return void
     * @throws \Exception
     */
    public function purge(): void
    {
        $cartData = $this->cartService->getCartDataFromSession();
        
        if (!empty($cartData)) {
            $this->cartService->setCartDataToSession([]);
        }
    }
    
    /**
     * 
     * @param array $cartData
     * @return bool
     */
    private function checkIsMaxProduct(array $cartData): bool
    {
        return count($cartData) == self::MAX_PRODUCT_IN_CART;
    }
}