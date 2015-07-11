<?php

include "vendor/autoload.php";

$fileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'data.yml';

//$storage = new \BSA2015\Basket\ArrayStorage();
$storage = new \BSA2015\Basket\YamlStorage($fileName);


$basketService = new \BSA2015\Basket\BasketService($storage);

$basket = $basketService->addBasket(['id' => 'basket1', 'name' => 'basket1']);
$basketService->addBasket(['name' => 'basket2']);
$basketService->addBasket(['name' => 'basket3']);

$basketService->addBasket($basket->getArrayCopy());
$basketService->updateBasket($basket, ['id' => 'basket10', 'total' => 15]);

$apple = $basketService->addProduct(['name' => 'apple', 'price' => 20]);
$pineapple = $basketService->addProduct(['name' => 'pineapple', 'price' => 50]);
$car = $basketService->addProduct(['name' => 'car', 'price' => 200000]);

$basketService->addBasketItem($basket, $apple, 5);
$basketService->addBasketItem($basket, $apple, 10);
$basketService->addBasketItem($basket, $pineapple, 10);
$basketService->addBasketItem($basket, $car, 1);

$storage->store(
    $basketService->getBasketArrayCopy(),
    $basketService->getProductArrayCopy(),
    $basketService->getBasketItemArrayCopy()
);

var_dump($storage);
