<?php

namespace BackendProgramer\SnappPay\Contracts;

interface OrderInterface
{
    /**
     * Build cart list from order.
     *
     * @return array
     */
    public function buildCartList(): array;
}
