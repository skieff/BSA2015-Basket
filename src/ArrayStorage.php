<?php

namespace BSA2015\Basket;

class ArrayStorage implements StorageInterface {
    function __construct()
    {
        $this->_storage = [
            'basket' => [],
            'product' => [],
            'basketItem' => [],
        ];
    }

    /**
     * @return \ArrayAccess
     */
    public function getBasketStorage()
    {
        return $this->_storage['basket'];
    }

    /**
     * @return \ArrayAccess
     */
    public function getProductStorage()
    {
        return $this->_storage['product'];
    }

    /**
     * @return \ArrayAccess
     */
    public function getBasketItemStorage()
    {
        return $this->_storage['basketItem'];
    }

    public function store(array $basket, array $product, array $basketItem)
    {
        $this->_storage = [
            'basket' => $basket,
            'product' => $product,
            'basketItem' => $basketItem,
        ];
    }
}