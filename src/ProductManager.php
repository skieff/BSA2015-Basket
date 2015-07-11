<?php

namespace BSA2015\Basket;

use BSA2015\Basket\Exception\ProductNotFound;

class ProductManager extends AbstractManager {

    /**
     * @param array $data
     * @return Product
     */
    public function addProduct(array $data = []) {
        return $this->_addItem($data);
    }

    /**
     * @param string|array $idOrData
     * @return Product
     * @throws ProductNotFound
     */
    public function findProduct($idOrData) {
        $product = $this->_getItem($idOrData);

        if (empty($product)) {
            throw new ProductNotFound($idOrData);
        }

        return $product;
    }

    /**
     * @param Product $product
     * @param array $data
     * @return Product
     * @throws ProductNotFound
     */
    public function updateProduct(Product $product, array $data) {
        $foundProduct = $this->_updateItem($product, $data);

        if (empty($foundProduct)) {
            throw new ProductNotFound($product);
        }

        return $foundProduct;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function _getId(array $data)
    {
        return Product::calculateId($data);
    }

    /**
     * @param string|array $idOrData
     * @return Product
     */
    protected function _newInstance($idOrData)
    {
        return new Product($idOrData);
    }
}