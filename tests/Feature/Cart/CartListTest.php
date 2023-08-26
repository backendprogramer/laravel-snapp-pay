<?php

use BackendProgramer\SnappPay\Cart\CartItem;
use BackendProgramer\SnappPay\Cart\CartList;
use BackendProgramer\SnappPay\Order\Order;
use BackendProgramer\SnappPay\Order\OrderProduct;
use BackendProgramer\SnappPay\Order\ProductCategory;

it('test cart list getter and setter methods', function () {
    $category = new ProductCategory('Electronics', 2);
    $orderProduct1 = new OrderProduct(1, 'Product 1', 100, 90, 2, $category);
    $orderProduct2 = new OrderProduct(2, 'Product 2', 50, 45, 3, $category);

    $order = new Order(123, 250, 280, 10, 20, 'IRT', '1234567890');

    $order->addProduct($orderProduct1);
    $order->addProduct($orderProduct2);

    $cartList = new CartList($order);

    $cartItem = new CartItem(3, 'Sample Product', 3, 150, $category);

    $cartList->addCartItem($cartItem);

    $this->assertSame($cartItem, $cartList->getCartItem(3));
    $this->assertNull($cartList->getCartItem(4));

    $this->assertEquals(10, $cartList->getShippingAmount());
    $this->assertTrue($cartList->getIsShipmentIncluded());
    $this->assertEquals(20, $cartList->getTaxAmount());
    $this->assertTrue($cartList->getIsTaxIncluded());
    $this->assertEquals('IRT', $cartList->getCartCurrency());

    $this->assertFalse($cartList->removeCartItem(4));
    $this->assertTrue($cartList->removeCartItem(3));
});
