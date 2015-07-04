<?php

namespace BSA2015\Basket;

use BSA2015\Basket\Exception\ProductNotFound;

abstract class AbstractManager {

    /**
     * @var \ArrayAccess|AbstractItem[]
     */
    protected $_storage;

    function __construct()
    {
        $this->_storage = new \ArrayIterator([]);
    }

    /**
     * @param \Traversable|array $data
     */
    public function loadData($data) {
        foreach ($data as $itemData) {
            $this->_addItem($itemData);
        }
    }

    public function getArrayCopy() {
        return array_map(
            function(AbstractItem $item) {return $item->getArrayCopy();},
            iterator_to_array($this->_storage)
        );
    }

    /**
     * @param array $data
     * @return AbstractItem
     */
    protected function _addItem(array $data = [])
    {
        $itemId = $this->_getId($data);

        $foundItem = isset($this->_storage[$itemId]) ? $this->_storage[$itemId] : $this->_newInstance($data);

        $foundItem->exchangeArray(array_merge($foundItem->getArrayCopy(), $data));
        $this->_storage[$foundItem->getId()] = $foundItem;

        return $foundItem;
    }

    /**
     * @param string|array $idOrData
     * @return AbstractItem|null
     */
    protected function _getItem($idOrData)
    {
        $item = $this->_newInstance($idOrData);
        return isset($this->_storage[$item->getId()]) ? $this->_storage[$item->getId()] : null;
    }
    /**
     * @param array $data
     * @return AbstractItem|null
     * @throws ProductNotFound
     */
    protected function _updateItem(array $data)
    {
        $itemId = $this->_getId($data);
        $foundItem = $this->_getItem($itemId);

        if (empty($foundItem)) {
            return null;
        }

        $foundItem->exchangeArray(array_merge($foundItem->getArrayCopy(), $data));

        return $foundItem;
    }

    /**
     * @param array $data
     * @return string
     */
    abstract protected function _getId(array $data);

    /**
     * @param string|array $idOrData
     * @return AbstractItem
     */
    abstract protected function _newInstance($idOrData);

}