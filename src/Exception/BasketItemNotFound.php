<?php

namespace BSA2015\Basket\Exception;

use BSA2015\Basket\BasketItem;
use Exception;

class BasketItemNotFound extends Exception {
    public function __construct(BasketItem $basketItem = null, Exception $previous = null)
    {
        parent::__construct('Basket Item #' . $basketItem->getId() . ' not found', 404, $previous);
    }

}