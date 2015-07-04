<?php

namespace BSA2015\Basket;

interface StorageInterface {
    /**
     * @return \Traversable
     */
    public function getBasketStorage();

    /**
     * @return \Traversable
     */
    public function getProductStorage();

    /**
     * @return \Traversable
     */
    public function getBasketItemStorage();

    public function store(array $basket, array $product, array $basketItem);
}