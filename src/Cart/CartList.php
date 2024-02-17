<?php

namespace BackendProgramer\SnappPay\Cart;

use BackendProgramer\SnappPay\Abstracts\CartList as AbstractsCartList;
use BackendProgramer\SnappPay\enums\Currency;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class CartList extends AbstractsCartList
{
    /**
     * Get SnappPay cart list array.
     *
     * @return array
     */
    #[Pure] #[ArrayShape(['cartId' => 'int', 'totalAmount' => 'int', 'shippingAmount' => 'int', 'isShipmentIncluded' => 'bool', 'taxAmount' => 'int', 'isTaxIncluded' => 'bool', 'cartItems' => 'array'])]
    public function toArray(): array
    {
        $cartList = [
            'cartId'             => $this->cartId,
            'totalAmount'        => self::convertPrice($this->totalAmount, $this->currency, Currency::RIAL),
            'shippingAmount'     => self::convertPrice($this->shippingAmount, $this->currency, Currency::RIAL),
            'isShipmentIncluded' => $this->isShipmentIncluded,
            'taxAmount'          => self::convertPrice($this->taxAmount, $this->currency, Currency::RIAL),
            'isTaxIncluded'      => $this->isTaxIncluded  ,
        ];
        $items = [];

        foreach ($this->cartItems as $cartItem) {
            $items[] = [
                'id'             => $cartItem->getId(),
                'name'           => $cartItem->getName(),
                'count'          => $cartItem->getCount(),
                'amount'         => self::convertPrice($cartItem->getAmount(), $this->currency, Currency::RIAL),
                'category'       => $cartItem->getCategory(),
                'commissionType' => $cartItem->getCommissionType(),
            ];
        }
        $cartList['cartItems'] = $items;

        return $cartList;
    }
}
