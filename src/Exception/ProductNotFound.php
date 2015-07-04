<?php

namespace BSA2015\Basket\Exception;

use BSA2015\Basket\Product;
use Exception;

class ProductNotFound extends Exception {
    public function __construct(Product $product = "", Exception $previous = null)
    {
        parent::__construct('Product #' . $product->getId() . ' not found.', 404, $previous);
    }
}