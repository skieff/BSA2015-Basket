<?php

namespace BSA2015\Basket;

class BasketService {
    /**
     * @var BasketManager
     */
    private $_basketManager;

    function __construct(StorageInterface $storage)
    {
        $this->_basketManager = new BasketManager();
        $this->_basketManager->loadData($storage->getBasketStorage());

        $this->_productManager = new ProductManager();
        $this->_productManager->loadData($storage->getProductStorage());

        $this->_basketItemManager = new BasketItemManager();
        $this->_basketItemManager->loadData($storage->getBasketItemStorage());
    }

    /**
     * @return array
     */
    public function getBasketArrayCopy() {
        return $this->_basketManager->getArrayCopy();
    }

    public function getProductArrayCopy() {
        return $this->_productManager->getArrayCopy();
    }

    public function getBasketItemArrayCopy() {
        return $this->_basketItemManager->getArrayCopy();
    }

    /**
     * @param array $data
     * @return Basket
     */
    public function addBasket(array $data = []) {
        return $this->_basketManager->addBasket($data);
    }

    /**
     * @param array $data
     * @return Basket
     * @throws Exception\BasketNotFound
     */
    public function updateBasket(array $data) {
        return $this->_basketManager->updateBasket($data);
    }

    /**
     * @param string|array $idOrData
     * @return Basket
     * @throws Exception\BasketNotFound
     */
    public function findBasket($idOrData) {
        return $this->_basketManager->findBasket($idOrData);
    }

    /**
     * @param Basket $basket
     * @return \CallbackFilterIterator|BasketItem[]
     */
    public function getBasketItems(Basket $basket) {
        return array_map(
            function(BasketItem $item) {return $item->getArrayCopy();},
            iterator_to_array($this->_basketItemManager->getBasketItems($basket))
        );
    }

    /**
     * @param Basket|array $basketOrItemData
     * @param Product|string|null $productOrId
     * @return BasketItem
     */
    public function findBasketItem($basketOrItemData, $productOrId = null) {
        return $this->_basketItemManager->findBasketItem($basketOrItemData, $productOrId);
    }

    public function updateBasketItem(array $data) {
        return $this->_basketItemManager->updateBasketItem($data);
    }

    /**
     * @param array $data
     * @return Product
     */
    public function addProduct(array $data = []) {
        return $this->_productManager->addProduct($data);
    }

    /**
     * @param $idOrData
     * @return Product
     * @throws Exception\ProductNotFound
     */
    public function findProduct($idOrData) {
        return $this->_productManager->findProduct($idOrData);
    }

    /**
     * @param Basket $basket
     * @param Product $product
     * @param int $amount
     * @return BasketItem
     */
    public function addBasketItem(Basket $basket, Product $product, $amount = 1) {
        $basketItem = $this->_basketItemManager->addBasketItem($basket, $product, $amount);
        $this->_basketManager->recalculateBasket($basket, $this->_basketItemManager->getBasketItems($basket));

        return $basketItem;
    }
}