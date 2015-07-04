<?php

namespace BSA2015\Basket;

use BSA2015\Basket\Exception\BasketNotFound;

class BasketManager extends AbstractManager {
    /**
     * @param array $data
     * @return Basket
     */
    public function addBasket(array $data = []) {
        return $this->_addItem($data);
    }

    /**
     * @param string|array $idOrData
     * @return Basket|null
     * @throws BasketNotFound
     */
    public function findBasket($idOrData) {
        $foundBasket = $this->_getItem($idOrData);

        if (empty($foundBasket)) {
            throw new BasketNotFound($this->_newInstance($idOrData));
        }

        return $foundBasket;
    }

    /**
     * @param array $data
     * @return Basket
     * @throws BasketNotFound
     */
    public function updateBasket(array $data) {
        $foundBasket = $this->_updateItem($data);

        if (empty($foundBasket)) {
            throw new BasketNotFound($this->_newInstance($data));
        }

        return $foundBasket;
    }

    /**
     * @param Basket $basket
     * @param \Iterator|BasketItem[] $basketItems
     * @return Basket
     * @throws BasketNotFound
     */
    public function recalculateBasket(Basket $basket, $basketItems) {
        $foundBasket = $this->findBasket($basket->getArrayCopy());

        $totalItems = 0;
        $totalPrice = 0;

        foreach ($basketItems as $basketItem) {
            $totalItems += $basketItem->itemsAmount;
            $totalPrice += $basketItem->totalPrice;
        }

        $foundBasket->updateTotals($totalItems, $totalPrice);

        return $foundBasket;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function _getId(array $data)
    {
        return Basket::calculateId($data);
    }

    /**
     * @param string|array $idOrData
     * @return Basket
     */
    protected function _newInstance($idOrData)
    {
        return new Basket($idOrData);
    }
}