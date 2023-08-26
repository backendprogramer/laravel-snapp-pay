<?php

use BackendProgramer\SnappPay\Cart\CartItem;
use BackendProgramer\SnappPay\Order\ProductCategory;

it('test cart item getter and setter Methods', function () {
    $id = 1;
    $name = 'Sample Product';
    $count = 3;
    $amount = 150;
    $category = new ProductCategory('Electronics', 2);

    $cartItem = new CartItem($id, $name, $count, $amount, $category);

    $this->assertEquals($id, $cartItem->getId());
    $this->assertEquals($name, $cartItem->getName());
    $this->assertEquals($count, $cartItem->getCount());
    $this->assertEquals($amount, $cartItem->getAmount());
    $this->assertEquals($category->getName(), $cartItem->getCategory());
    $this->assertEquals($category->getCommissionType(), $cartItem->getCommissionType());

    $id = 2;
    $name = 'Updated Product';
    $count = 5;
    $amount = 200;
    $category = new ProductCategory('Clothing', 1);

    $cartItem->setId($id);
    $cartItem->setName($name);
    $cartItem->setCount($count);
    $cartItem->setAmount($amount);
    $cartItem->setCategory($category->getName());
    $cartItem->setCommissionType($category->getCommissionType());

    $this->assertEquals($id, $cartItem->getId());
    $this->assertEquals($name, $cartItem->getName());
    $this->assertEquals($count, $cartItem->getCount());
    $this->assertEquals($amount, $cartItem->getAmount());
    $this->assertEquals($category->getName(), $cartItem->getCategory());
    $this->assertEquals($category->getCommissionType(), $cartItem->getCommissionType());
});
