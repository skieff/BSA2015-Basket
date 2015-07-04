<?php

namespace BSA2015\Basket;

use Symfony\Component\Yaml\Yaml;

class YamlStorage implements StorageInterface {
    const BASKET = 'basket';
    const PRODUCT = 'product';
    const BASKET_ITEM = 'basketItem';

    private $_storage = null;
    private $_filePath;

    function __construct($filePath)
    {
        $this->_filePath = $filePath;
    }

    /**
     * @return \ArrayAccess
     */
    public function getBasketStorage()
    {
        return $this->_getStorage()[static::BASKET];
    }

    /**
     * @return \ArrayAccess
     */
    public function getProductStorage()
    {
        return $this->_getStorage()[static::PRODUCT];
    }

    /**
     * @return \ArrayAccess
     */
    public function getBasketItemStorage()
    {
        return $this->_getStorage()[static::BASKET_ITEM];
    }

    private function _getStorage() {
        if (is_null($this->_storage)) {
            $fileData = $this->_loadFileData();

            $this->_storage = [
                static::BASKET => isset($fileData[static::BASKET]) ? $fileData[static::BASKET] : [],
                static::PRODUCT => isset($fileData[static::PRODUCT]) ? $fileData[static::PRODUCT] : [],
                static::BASKET_ITEM => isset($fileData[static::BASKET_ITEM]) ? $fileData[static::BASKET_ITEM] : [],
            ];
        }

        return $this->_storage;
    }

    private function _loadFileData() {
        return Yaml::parse(file_get_contents($this->_filePath));
    }

    public function store(array $basket, array $product, array $basketItem)
    {
        $this->_storage = [
            static::BASKET => $basket,
            static::PRODUCT => $product,
            static::BASKET_ITEM => $basketItem,
        ];

        file_put_contents($this->_filePath, Yaml::dump($this->_storage));
    }
}