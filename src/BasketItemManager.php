<?php

namespace BSA2015\Basket;

use BSA2015\Basket\Exception\BasketItemNotFound;

class BasketItemManager extends AbstractManager {

    public function addBasketItem(Basket $basket, Product $product, $amount = 1) {
        $data = [
            'basket' => $basket->getId(),
            'product' => $product->getId(),
            'name' => $product->name,
            'price' => $product->price,
        ];

        /** @var BasketItem $basketItem */
        $basketItem = $this->_addItem($data);
        $basketItem->addItems($amount);

        return $basketItem;
    }

    /**
     * @param Basket $basket
     * @return \CallbackFilterIterator|BasketItem[]
     */
    public function getBasketItems(Basket $basket) {
        return new \CallbackFilterIterator(
            new \ArrayIterator($this->_storage),
            function(BasketItem $basketItem)use($basket){return $basketItem->basket === $basket->getId();}
        );
    }

    /**
     * @param Basket $basket
     * @param Product $product
     * @return BasketItem
     * @throws BasketItemNotFound
     */
    public function findBasketItem(Basket $basket, Product $product) {
        $data = [
            'basket' => $basket->getId(),
            'product' => $product->getId(),
        ];

        $item = $this->_getItem($data);

        if (empty($item)) {
            throw new BasketItemNotFound($this->_newInstance($data));
        }

        return $item;
    }

    public function updateBasketItem(BasketItem $basketItem, array $data) {
        /** @var BasketItem $foundBasketItem */
        $foundBasketItem = $this->_updateItem($basketItem, $data);

        if (empty($foundBasketItem)) {
            throw new BasketItemNotFound($basketItem);
        }

        $foundBasketItem->recalculate();

        return $foundBasketItem;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function _getId(array $data)
    {
        return BasketItem::calculateId($data);
    }

    /**
     * @param string|array $idOrData
     * @return IdProviderInterface
     */
    protected function _newInstance($idOrData)
    {
        return new BasketItem($idOrData);
    }
}