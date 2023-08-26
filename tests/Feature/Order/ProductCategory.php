<?php

use BackendProgramer\SnappPay\Order\ProductCategory;

it('test get name', function () {
    $category = new ProductCategory('Electronics');
    $this->assertEquals('Electronics', $category->getName());
});

it('test set name', function () {
    $category = new ProductCategory();
    $category->setName('Clothing');
    $this->assertEquals('Clothing', $category->getName());
    $this->assertEquals(null, $category->getCommissionType());
});

it('test get commission type', function () {
    $category = new ProductCategory('Books', 1);
    $this->assertEquals(1, $category->getCommissionType());
});

it('test set commission type', function () {
    $category = new ProductCategory();
    $category->setCommissionType(3);
    $this->assertEquals(3, $category->getCommissionType());
});
