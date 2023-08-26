<?php

namespace BackendProgramer\SnappPay\Cart;

use BackendProgramer\SnappPay\Order\ProductCategory;
use JetBrains\PhpStorm\Pure;

class CartItem
{
    /**
     * Cart item id.
     *
     * @var int id
     */
    protected int $id;

    /**
     * Cart item name.
     *
     * @var string name
     */
    protected string $name;

    /**
     * Cart item count.
     *
     * @var int count
     */
    protected int $count;

    /**
     * Cart item amount.
     *
     * @var int amount
     */
    protected int $amount;

    /**
     * Cart item category name.
     *
     * @var string category
     */
    protected string $category;

    /**
     * Cart item commission type.
     *
     * @var int commissionType
     */
    protected int $commissionType;

    /**
     * SnappPay cartItem constructor.
     *
     * @param int             $id
     * @param string          $name
     * @param int             $count
     * @param int             $amount
     * @param ProductCategory $productCategory
     */
    #[Pure]
    public function __construct(int $id, string $name, int $count, int $amount, ProductCategory $productCategory)
    {
        $this->id = $id;
        $this->name = $name;
        $this->count = $count;
        $this->amount = $amount;
        $this->category = $productCategory->getName();
        $this->commissionType = $productCategory->getCommissionType();
    }

    /**
     * Set the cart item id.
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
     * Get the cart item id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the cart item name.
     *
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the cart item name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the cart item count.
     *
     * @param int $count
     *
     * @return void
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * Get the cart item count.
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * Set the cart item amount.
     *
     * @param int $amount
     *
     * @return void
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Get the cart item amount.
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Set the cart item category name.
     *
     * @param string $category
     *
     * @return void
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * Get the cart item category name.
     *
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category ?? '';
    }

    /**
     * Set the cart item commission type.
     *
     * @param int $commissionType
     *
     * @return void
     */
    public function setCommissionType(int $commissionType = 0): void
    {
        $this->commissionType = $commissionType;
    }

    /**
     * Get the cart item commission type.
     *
     * @return int|null
     */
    public function getCommissionType(): ?int
    {
        return $this->commissionType != 0 ? $this->commissionType : null;
    }
}
