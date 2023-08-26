<?php

namespace BackendProgramer\SnappPay\Order;

class ProductCategory
{
    /**
     * Category name.
     *
     * @var string name
     */
    protected string $name;

    /**
     * category commission type.
     *
     * @var int commissionType
     */
    protected int $commissionType;

    /**
     * SnappPayProductCategory constructor.
     *
     * @param string $name
     * @param int    $commissionType
     */
    public function __construct(string $name = '', int $commissionType = 0)
    {
        $this->name = $name;
        $this->commissionType = $commissionType;
    }

    /**
     * Set the category name.
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
     * Retrieve category name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the category commissionType.
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
     * Retrieve category commissionType.
     *
     * @return int
     */
    public function getCommissionType(): int
    {
        return $this->commissionType;
    }
}
