<?php

namespace BSA2015\Basket\Exception;

use BSA2015\Basket\Basket;

class BasketNotFound extends Exception {
    public function __construct(Basket $basket, Exception $previous = null)
    {
        parent::__construct('Basket #' . $basket->getId() . ' not found', 404, $previous);
    }

}