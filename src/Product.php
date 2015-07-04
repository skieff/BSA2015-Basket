<?php

namespace BSA2015\Basket;

/**
 * Class Product
 * @package BSA2015\Basket
 *
 * @property string id;
 * @property string name;
 * @property float price
 */
class Product extends AbstractItem {

    /**
     * @param array|string $idOrData
     */
    public function __construct($idOrData)
    {
        $idOrData = is_string($idOrData) ? ['id' => $idOrData] : $idOrData;

        $idOrData = array_merge([
            'id' => uniqid('P'),
            'name' => '',
            'price' => 0,
        ] , $idOrData);

        parent::__construct(static::_parse($idOrData), \ArrayObject::ARRAY_AS_PROPS, 'ArrayIterator');
    }

    private static function _parse($data) {
        (!isset($data['price'])) ?: $data['price'] = floatval($data['price']);

        return $data;
    }

    public function getId() {
        return $this->id;
    }

    public static function calculateId($data) {
        return isset($data['id']) ? $data['id'] : '';
    }
}