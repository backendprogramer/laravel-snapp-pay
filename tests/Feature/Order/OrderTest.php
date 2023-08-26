<?php

use BackendProgramer\SnappPay\Order\Order;
use BackendProgramer\SnappPay\Order\OrderProduct;
use BackendProgramer\SnappPay\Order\ProductCategory;

it('test setter and getter methods', function () {
    $category = new ProductCategory('Electronics', 2);
    $orderProduct1 = new OrderProduct(1, 'Product 1', 100, 90, 2, $category);
    $orderProduct2 = new OrderProduct(2, 'Product 2', 50, 45, 3, $category);

    $order = new Order(123, 250, 280, 10, 20, 'IRT', '1234567890');

    $this->assertEquals(123, $order->getId());
    $this->assertEquals(250, $order->getPrice());
    $this->assertEquals(280, $order->getTotalPrice());
    $this->assertEquals(10, $order->getShippingAmount());
    $this->assertEquals(20, $order->getTaxAmount());
    $this->assertEquals('IRT', $order->getOrderCurrency());
    $this->assertEquals('1234567890', $order->getUserMobile());
    $this->assertNull($order->getPaymentToken());

    $order->setId(456);
    $order->setPrice(300);
    $order->setTotalPrice(330);
    $order->setShippingAmount(15);
    $order->setTaxAmount(25);
    $order->setOrderCurrency('IRR');
    $order->setUserMobile('9876543210');
    $order->setPaymentToken('token123');

    $this->assertEquals(456, $order->getId());
    $this->assertEquals(300, $order->getPrice());
    $this->assertEquals(330, $order->getTotalPrice());
    $this->assertEquals(15, $order->getShippingAmount());
    $this->assertEquals(25, $order->getTaxAmount());
    $this->assertEquals('IRR', $order->getOrderCurrency());
    $this->assertEquals('9876543210', $order->getUserMobile());
    $this->assertEquals('token123', $order->getPaymentToken());

    $order->addProduct($orderProduct1);
    $order->addProduct($orderProduct2);

    $this->assertEquals([$orderProduct1, $orderProduct2], $order->getOrderProducts());
    $this->assertSame($orderProduct1, $order->getOrderProduct(1));
    $this->assertSame($orderProduct2, $order->getOrderProduct(2));
    $this->assertNull($order->getOrderProduct(3));

    $this->assertFalse($order->removeProduct(3));
    $this->assertTrue($order->removeProduct(2, true));
    $this->assertEquals(180, $order->getTotalPrice());
});

it('test build cart list method', function () {
    $category = new ProductCategory('Electronics');
    $orderProduct1 = new OrderProduct(1, 'Product 1', 100, 90, 2, $category);
    $orderProduct2 = new OrderProduct(2, 'Product 2', 50, 45, 3, $category);

    $order = new Order(123, 250, 280, 10, 20, 'IRT', '1234567890');

    $order->addProduct($orderProduct1);
    $order->addProduct($orderProduct2);

    $cartList = $order->buildCartList();

    $expectedCartList = [
        'cartId'             => 123,
        'totalAmount'        => 2800,
        'shippingAmount'     => 100,
        'isShipmentIncluded' => true,
        'taxAmount'          => 200,
        'isTaxIncluded'      => true,
        'cartItems'          => [
            [
                'id'             => 1,
                'name'           => 'Product 1',
                'count'          => 2,
                'amount'         => 900,
                'category'       => 'Electronics',
                'commissionType' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Product 2',
                'count'          => 3,
                'amount'         => 450,
                'category'       => 'Electronics',
                'commissionType' => null,
            ],
        ],
    ];

    $this->assertSame($expectedCartList, $cartList);
});
