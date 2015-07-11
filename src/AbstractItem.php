<?php

namespace BSA2015\Basket;

abstract class AbstractItem extends \ArrayObject implements IdProviderInterface {
    abstract public function update($data);
}