<?php

namespace BSA2015\Basket;

use BSA2015\Basket\Exception\BasketItemNotFound;

class BasketItemManager extends AbstractManager {

    public function addBasketItem(Basket $basket, Product $product, $amount = 1) {
        $data = [
            'basket' => $basket->getId(),
            'product' => $product->getId(),
            'price' => $product->price,
        ];

        /** @var BasketItem $basketItem */
        $basketItem = $this->_addItem($data);
        $basketItem->addItems($amount);

        return $basketItem;
    }

    /**
     * @param Basket $basket
     * @return \CallbackFilterIterator
     */
    public function getBasketItems(Basket $basket) {
        return new \CallbackFilterIterator(
            new \ArrayIterator($this->_storage),
            function(BasketItem $basketItem)use($basket){return $basketItem->basket === $basket->getId();}
        );
    }

    /**
     * @param Basket|array $basketOrItemData
     * @param Product|string|null $productOrId
     * @return BasketItem
     * @throws BasketItemNotFound
     */
    public function findBasketItem($basketOrItemData, $productOrId = null) {
        $data = [];

        if ($basketOrItemData instanceof Basket) {
            $data['basket'] = $basketOrItemData->getId();
        } else {
            $data = $basketOrItemData;
        }

        if ($productOrId instanceof Product) {
            $data['product'] = $productOrId->getId();
        } elseif (is_string($productOrId)) {
            $data['product'] = $productOrId;
        } else {
            //do nothing
        }

        $item = $this->_getItem($data);

        if (empty($item)) {
            throw new BasketItemNotFound($this->_newInstance($data));
        }

        return $item;
    }

    public function updateBasketItem(array $data) {
        /** @var BasketItem $basketItem */
        $basketItem = $this->_updateItem($data);

        if (empty($basketItem)) {
            throw new BasketItemNotFound($this->_newInstance($data));
        }

        $basketItem->recalculate();

        return $basketItem;
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