<?php

namespace BSA2015\Basket;

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
     * @param AbstractItem $existedItem
     * @param array $data
     * @return AbstractItem|null
     */
    protected function _updateItem(AbstractItem $existedItem, array $data)
    {
        $previousId = $existedItem->getId();
        $foundItem = $this->_getItem($existedItem->getArrayCopy());

        if (empty($foundItem)) {
            return null;
        }

        $foundItem->update($data);

        if (isset($this->_storage[$previousId])) unset($this->_storage[$previousId]);

        $this->_storage[$foundItem->getId()] = $foundItem;

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