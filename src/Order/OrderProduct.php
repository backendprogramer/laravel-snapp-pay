<?php

namespace BackendProgramer\SnappPay\Order;

class OrderProduct
{
    /**
     * Product id.
     *
     * @var int id
     */
    protected int $id;

    /**
     * Product title.
     *
     * @var string itle
     */
    protected string $title;

    /**
     * Product price.
     *
     * @var int price
     */
    protected int $price;

    /**
     * Product price with discount.
     *
     * @var int priceWithDiscount
     */
    protected int $priceWithDiscount;

    /**
     * Product quantity.
     *
     * @var int qty
     */
    protected int $qty;

    /**
     * Product category.
     *
     * @var ProductCategory category
     */
    protected ProductCategory $category;

    /**
     * Driver constructor.
     *
     * @param int             $id
     * @param string          $title
     * @param int             $price
     * @param int             $priceWithDiscount
     * @param int             $qty
     * @param ProductCategory $category
     */
    public function __construct(int $id, string $title, int $price, int $priceWithDiscount, int $qty, ProductCategory $category)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->priceWithDiscount = $priceWithDiscount;
        $this->qty = $qty;
        $this->category = $category;
    }

    /**
     * Set the product id.
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
     * Retrieve product id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the product title.
     *
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Retrieve product title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the product price.
     *
     * @param int $price
     *
     * @return void
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * Retrieve product price.
     *
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Set the product price with discount.
     *
     * @param int $priceWithDiscount
     *
     * @return void
     */
    public function setPriceWithDiscount(int $priceWithDiscount): void
    {
        $this->priceWithDiscount = $priceWithDiscount;
    }

    /**
     * Retrieve product price with discount.
     *
     * @return int
     */
    public function getPriceWithDiscount(): int
    {
        return $this->priceWithDiscount;
    }

    /**
     * Set the product quantity.
     *
     * @param int $qty
     *
     * @return void
     */
    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }

    /**
     * Retrieve product quantity.
     *
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * Set the product category.
     *
     * @param ProductCategory $category
     *
     * @return void
     */
    public function setCategory(ProductCategory $category): void
    {
        $this->category = $category;
    }

    /**
     * Retrieve product category.
     *
     * @return ProductCategory
     */
    public function getCategory(): ProductCategory
    {
        return $this->category;
    }
}
