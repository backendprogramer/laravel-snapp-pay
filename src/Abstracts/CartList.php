<?php

namespace BackendProgramer\SnappPay\Abstracts;

use BackendProgramer\SnappPay\Cart\CartItem;
use BackendProgramer\SnappPay\Contracts\CartListInterface;
use BackendProgramer\SnappPay\Order\Order;
use BackendProgramer\SnappPay\Traits\OrderSettings;

abstract class CartList implements CartListInterface
{
    use OrderSettings;

    /**
     * Cart id.
     *
     * @var int cartId
     */
    protected int $cartId;

    /**
     * Cart total amount.
     *
     * @var int totalAmount
     */
    protected int $totalAmount;

    /**
     * Cart items.
     *
     * @var array cartItems
     */
    protected array $cartItems;

    /**
     * Cart shipping amount.
     *
     * @var int shippingAmount
     */
    protected int $shippingAmount;

    /**
     * Cart amount is shipment included.
     *
     * @var bool isShipmentIncluded
     */
    protected bool $isShipmentIncluded;

    /**
     * Cart tax amount.
     *
     * @var int taxAmount
     */
    protected int $taxAmount;

    /**
     * Cart amount is tax included.
     *
     * @var bool isTaxIncluded
     */
    protected bool $isTaxIncluded;

    /**
     * Cart currency.
     *
     * @var string currency
     */
    protected string $currency;

    /**
     * SnappPay cartList constructor.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->cartItems = [];
        $this->cartId = $order->getId();
        $this->totalAmount = $order->getTotalPrice();
        $this->shippingAmount = $order->getShippingAmount();
        $this->isShipmentIncluded = $order->getShippingAmount() > 0;
        $this->taxAmount = $order->getTaxAmount();
        $this->isTaxIncluded = $order->getTaxAmount() >= 0;
        $this->currency = $order->getOrderCurrency();

        foreach ($order->getOrderProducts() as $product) {
            $category = $product->getCategory();
            $cartItem = new CartItem($product->getId(), $product->getTitle(), $product->getQty(), $product->getPriceWithDiscount(), $category);
            $this->addCartItem($cartItem);
        }
    }

    /**
     * Add cart item.
     *
     *
     *
     * @param CartItem $cartItem
     *
     * @return void
     * @return void
     */
    public function addCartItem(CartItem $cartItem)
    {
        $this->cartItems[] = $cartItem;
    }

    /**
     * Add cart item.
     */
    public function removeCartItem(int $id): bool
    {
        foreach ($this->cartItems as $key => $cartItem) {
            if ($cartItem->getId() == $id) {
                unset($this->cartItems[$key]);

                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve cart item by Id.
     *
     * @param $id
     *
     * @return CartItem|null
     */
    public function getCartItem($id): ?CartItem
    {
        foreach ($this->cartItems as $cartItem) {
            if ($cartItem->getId() == $id) {
                return $cartItem;
            }
        }

        return null;
    }

    /**
     * Set cart shipping amount.
     *
     * @param int $shippingAmount
     *
     * @return void
     */
    public function setShippingAmount(int $shippingAmount): void
    {
        $this->shippingAmount = $shippingAmount;
    }

    /**
     * Retrieve cart shipping amount.
     *
     * @return int
     */
    public function getShippingAmount(): int
    {
        return $this->shippingAmount;
    }

    /**
     * Set cart isShipmentIncluded.
     *
     * @param bool $isShipmentIncluded
     *
     * @return void
     */
    public function setIsShipmentIncluded(bool $isShipmentIncluded): void
    {
        $this->isShipmentIncluded = $isShipmentIncluded;
    }

    /**
     * Retrieve cart isShipmentIncluded.
     *
     * @return bool
     */
    public function getIsShipmentIncluded(): bool
    {
        return $this->isShipmentIncluded;
    }

    /**
     * Set cart tax amount.
     *
     * @param int $taxAmount
     *
     * @return void
     */
    public function setTaxAmount(int $taxAmount): void
    {
        $this->taxAmount = $taxAmount;
    }

    /**
     * Retrieve cart tax amount.
     *
     * @return int
     */
    public function getTaxAmount(): int
    {
        return $this->taxAmount;
    }

    /**
     * Set cart isTaxIncluded.
     *
     * @param bool $isTaxIncluded
     *
     * @return void
     */
    public function setIsTaxIncluded(bool $isTaxIncluded): void
    {
        $this->isTaxIncluded = $isTaxIncluded;
    }

    /**
     * Retrieve cart isTaxIncluded.
     *
     * @return bool
     */
    public function getIsTaxIncluded(): bool
    {
        return $this->isTaxIncluded;
    }

    /**
     * Set cart currency.
     *
     * @param string $currency
     *
     * @return void
     */
    public function setCartCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Retrieve cart currency.
     *
     * @return string
     */
    public function getCartCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Get SnappPay cart list array.
     *
     * @return array
     */
    abstract public function toArray(): array;
}
