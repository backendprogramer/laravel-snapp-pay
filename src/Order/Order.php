<?php

namespace BackendProgramer\SnappPay\Order;

use BackendProgramer\SnappPay\Abstracts\Order as AbstractsOrder;
use BackendProgramer\SnappPay\Cart\CartList;
use JetBrains\PhpStorm\ArrayShape;

class Order extends AbstractsOrder
{
    /**
     * SnappPay Order build cart list.
     *
     * @return array
     */
    #[ArrayShape(['cartId' => 'int', 'totalAmount' => 'int', 'shippingAmount' => 'int', 'isShipmentIncluded' => 'bool', 'taxAmount' => 'int', 'isTaxIncluded' => 'bool', 'cartItems' => 'array'])]
    public function buildCartList(): array
    {
        $cartList = new CartList($this);

        return $cartList->toArray();
    }
}
