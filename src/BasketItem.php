<?php

namespace BSA2015\Basket;

/**
 * Class BasketItem
 * @package BSA2015\Basket
 *
 * @property string id;
 * @property string basket;
 * @property string product;
 * @property int itemsAmount
 * @property float price
 * @property float totalPrice
 */
class BasketItem extends AbstractItem {
    public function __construct($idOrData = [])
    {
        $idOrData = is_string($idOrData) ? ['id' => $idOrData] : $idOrData;

        $idOrData = array_merge([
            'id' => '',
            'basket' => '',
            'product' => '',
            'name' => '',
            'price' => 0,
            'itemsAmount' => 0,
            'totalPrice' => 0,
        ] , $idOrData);

        parent::__construct(static::_parse($idOrData), \ArrayObject::ARRAY_AS_PROPS, 'ArrayIterator');
    }

    public function addItems($amount) {
        $this->itemsAmount += $amount;
        $this->recalculate();
    }

    public function recalculate() {
        $this->totalPrice = $this->itemsAmount * $this->price;
    }

    private static function _parse($data) {
        (!isset($data['itemsAmount'])) ?: $data['itemsAmount'] = intval($data['itemsAmount']);
        (!isset($data['price'])) ?: $data['price'] = floatval($data['price']);
        (!isset($data['totalPrice'])) ?: $data['totalPrice'] = floatval($data['totalPrice']);
        (!isset($data['name'])) ?: $data['name'] = (isset($data['product']) ? $data['product'] : '');

        $data['id'] = static::calculateId($data);

        return $data;
    }

    public function getId() {
        return $this->id;
    }

    public static function calculateId($data) {
        $parts = [
            isset($data['basket']) ? $data['basket'] : '',
            isset($data['product']) ? $data['product'] : '',
        ];

        return implode('/', $parts);
    }

    public function update($data)
    {
        $this->exchangeArray($this->_parse(array_merge($this->getArrayCopy(), $data)));
        return $this;
    }
}