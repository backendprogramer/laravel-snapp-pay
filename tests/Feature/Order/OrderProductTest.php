<?php

use BackendProgramer\SnappPay\Order\OrderProduct;
use BackendProgramer\SnappPay\Order\ProductCategory;

it('test getter and setter methods', function () {
    $category = new ProductCategory('Electronics');
    $orderProduct = new OrderProduct(1, 'Product 1', 100, 90, 2, $category);

    $this->assertEquals(1, $orderProduct->getId());
    $this->assertEquals('Product 1', $orderProduct->getTitle());
    $this->assertEquals(100, $orderProduct->getPrice());
    $this->assertEquals(90, $orderProduct->getPriceWithDiscount());
    $this->assertEquals(2, $orderProduct->getQty());
    $this->assertSame($category, $orderProduct->getCategory());

    $newCategory = new ProductCategory('Clothing', 2);

    $orderProduct->setId(2);
    $orderProduct->setTitle('Updated Product');
    $orderProduct->setPrice(150);
    $orderProduct->setPriceWithDiscount(140);
    $orderProduct->setQty(3);
    $orderProduct->setCategory($newCategory);

    $this->assertEquals(2, $orderProduct->getId());
    $this->assertEquals('Updated Product', $orderProduct->getTitle());
    $this->assertEquals(150, $orderProduct->getPrice());
    $this->assertEquals(140, $orderProduct->getPriceWithDiscount());
    $this->assertEquals(3, $orderProduct->getQty());
    $this->assertSame($newCategory, $orderProduct->getCategory());
});
