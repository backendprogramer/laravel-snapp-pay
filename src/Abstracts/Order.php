<?php

namespace BackendProgramer\SnappPay\Abstracts;

use BackendProgramer\SnappPay\Contracts\OrderInterface;
use BackendProgramer\SnappPay\Order\OrderProduct;

abstract class Order implements OrderInterface
{
    /**
     * Order Id.
     *
     * @var int id
     */
    protected int $id;

    /**
     * Order price without discount.
     *
     * @var int price
     */
    protected int $price;

    /**
     * Order total price.
     *
     * @var int totalPrice
     */
    protected int $totalPrice;

    /**
     * orderProducts.
     *
     * @var array orderProducts
     */
    protected array $orderProducts;

    /**
     * Order shipping amount.
     *
     * @var int shippingAmount
     */
    protected int $shippingAmount;

    /**
     * Order tax amount.
     *
     * @var int taxAmount
     */
    protected int $taxAmount;

    /**
     * Order currency.
     *
     * @var string orderCurrency
     */
    protected string $orderCurrency;

    /**
     * Order user mobile.
     *
     * @var string userMobile
     */
    protected string $userMobile;

    /**
     * Order payment token.
     *
     * @var string paymentToken
     */
    protected string $paymentToken;

    /**
     * SnappPay Order constructor.
     *
     * @param int    $id
     * @param int    $price
     * @param int    $totalPrice
     * @param int    $shippingAmount
     * @param int    $taxAmount
     * @param string $orderCurrency
     * @param string $userMobile
     * @param string $paymentToken
     */
    public function __construct(int $id, int $price, int $totalPrice, int $shippingAmount, int $taxAmount, string $orderCurrency, string $userMobile, string $paymentToken = '')
    {
        $this->orderProducts = [];
        $this->id = $id;
        $this->price = $price;
        $this->totalPrice = $totalPrice;
        $this->shippingAmount = $shippingAmount;
        $this->taxAmount = $taxAmount;
        $this->orderCurrency = $orderCurrency;
        $this->userMobile = $userMobile;
        $this->paymentToken = $paymentToken;
    }

    /**
     * SnappPay Order build cart list.
     */
    abstract public function buildCartList(): array;

    /**
     * Add order products.
     *
     * @param OrderProduct $product
     * @param bool         $updateOrderPrice
     *
     * @return void
     */
    public function addProduct(OrderProduct $product, bool $updateOrderPrice = false): void
    {
        $this->orderProducts[] = $product;
        if ($updateOrderPrice) {
            $this->price += ($product->getPriceWithDiscount() * $product->getQty());
            $this->totalPrice += ($product->getPrice() * $product->getQty());
        }
    }

    /**
     * Remove order products.
     *
     * @param int  $id
     * @param bool $updateOrderPrice
     *
     * @return bool
     */
    public function removeProduct(int $id, bool $updateOrderPrice = false): bool
    {
        foreach ($this->orderProducts as $key => $product) {
            if ($product->getId() == $id) {
                if ($updateOrderPrice) {
                    $this->price -= ($product->getPriceWithDiscount() * $product->getQty());
                    $this->totalPrice -= ($product->getPrice() * $product->getQty());
                }
                unset($this->orderProducts[$key]);

                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve order product by productId.
     *
     * @param int $id
     *
     * @return OrderProduct|null
     */
    public function getOrderProduct(int $id): ?OrderProduct
    {
        foreach ($this->orderProducts as $product) {
            if ($product->getId() == $id) {
                return $product;
            }
        }

        return null;
    }

    /**
     * Retrieve order products Array.
     *
     * @return array
     */
    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }

    /**
     * Set order id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Retrieve order id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set order price.
     *
     * @param int $price
     *
     * @return void
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * Retrieve order price.
     *
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Set order total price.
     *
     *
     * @param int $totalPrice
     *
     * @return void
     * @return void
     */
    public function setTotalPrice(int $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * Retrieve order total price.
     *
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    /**
     * Set order shipping amount.
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
     * Retrieve order shipping amount.
     *
     * @return int
     */
    public function getShippingAmount(): int
    {
        return $this->shippingAmount;
    }

    /**
     * Set order tax amount.
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
     * Retrieve order tax amount.
     *
     * @return int
     */
    public function getTaxAmount(): int
    {
        return $this->taxAmount;
    }

    /**
     * Set order currency.
     *
     * @param string $orderCurrency
     *
     * @return void
     */
    public function setOrderCurrency(string $orderCurrency): void
    {
        $this->orderCurrency = $orderCurrency;
    }

    /**
     * Retrieve order currency.
     *
     * @return string
     */
    public function getOrderCurrency(): string
    {
        return $this->orderCurrency;
    }

    /**
     * Set user mobile.
     *
     * @param string $userMobile
     *
     * @return void
     */
    public function setUserMobile(string $userMobile): void
    {
        $this->userMobile = $userMobile;
    }

    /**
     * Retrieve user mobile.
     *
     * @return string
     */
    public function getUserMobile(): string
    {
        return $this->userMobile;
    }

    /**
     * Set order payment token.
     *
     * @param string $paymentToken
     *
     * @return void
     */
    public function setPaymentToken(string $paymentToken): void
    {
        $this->paymentToken = $paymentToken;
    }

    /**
     * Retrieve order payment token.
     *
     * @return string|null
     */
    public function getPaymentToken(): ?string
    {
        return $this->paymentToken != '' ? $this->paymentToken : null;
    }
}
