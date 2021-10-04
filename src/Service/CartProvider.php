<?php
namespace App\Service;

use App\Service\CartService;

class CartProvider
{ 
    /**
     * 
     * @var CartService 
     */
    private $cartService;
    
    /**
     * 
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    
    /**
     * @return array
     */
    public function getCartData(): array 
    {
        $cartData = $this->cartService->getCartDataFromSession();
        
        return $this->cartService->decorateCartResponse($cartData);
    }
}