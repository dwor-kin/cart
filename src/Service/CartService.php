<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    CONST SESSION_PREFIX = "cart_";
    
    /** 
     *
     * @var RequestStack
     */
    private $requestStack;
    
    /**
     * 
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    /**
     * 
     * @return array
     */
    public function getCartDataFromSession(): array 
    {
        $session = $this->requestStack->getSession();
        $data = $session->get($this->getCartName());
        
        return $data ? $data : [];
    }
    
    /**
     * 
     * @param array $cartData
     * @return void
     */
    public function setCartDataToSession(array $cartData): void
    {
        $session = $this->requestStack->getSession();
        $session->set($this->getCartName(), $cartData);
    }
    
    /**
     * 
     * @param array $data
     * @return float
     */
    private function getSumProductCart(array $data): float 
    {
        $sum = 0;
        
        foreach ($data as $key => $value) {
            $sum += $value['price'];
        }
        
        return $sum;
    }
    
    /**
     * 
     * @param array $cartData
     * @return array
     */
    public function decorateCartResponse($cartData): array 
    {
        return !empty($cartData) 
            ? ["products" => $cartData, "sum" => $this->getSumProductCart($cartData)]
            : ["products" => [], "sum" => 0];
    }
    
    /**
     * 
     * @return string
     */
    private function getCartName(): string 
    {
        $ip = $this->requestStack->getMasterRequest()->getClientIp();
        return self::SESSION_PREFIX . $ip;
    }
}