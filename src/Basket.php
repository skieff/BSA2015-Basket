<?php

namespace BSA2015\Basket;

/**
 * Class Basket
 * @package BSA2015\Basket
 *
 * @property string id;
 * @property string name;
 * @property int itemsAmount
 * @property float totalPrice
 */
class Basket extends AbstractItem {
    /**
     * @param array|string $idOrData
     */
    public function __construct($idOrData)
    {
        $idOrData = is_string($idOrData) ? ['id' => $idOrData] : $idOrData;

        $idOrData = array_merge([
            'id' => uniqid('B'),
            'name' => '',
            'itemsAmount' => 0,
            'totalPrice' => 0,
        ] , $idOrData);

        parent::__construct(static::_parse($idOrData), \ArrayObject::ARRAY_AS_PROPS, 'ArrayIterator');
    }

    public function updateTotals($items, $price) {
        $this->itemsAmount = intval($items);
        $this->totalPrice = floatval($price);
    }

    private static function _parse($data) {
        (!isset($data['itemsAmount'])) ?: $data['itemsAmount'] = intval($data['itemsAmount']);
        (!isset($data['totalPrice'])) ?: $data['totalPrice'] = floatval($data['totalPrice']);

        return $data;
    }

    public function getId() {
        return $this->id;
    }

    public static function calculateId($data) {
        return isset($data['id']) ? $data['id'] : '';
    }

    public function update($data)
    {
        $this->exchangeArray($this->_parse(array_merge($this->getArrayCopy(), $data)));
        return $this;
    }
}
